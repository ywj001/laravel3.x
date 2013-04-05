<?php
class Minfy{
	/**
	 * Minify
	 *
	 * Reduce excessive size of HTML/CSS/JavaScript content.
	 *
	 * @param	string	$output	Output to minify
	 * @param	string	$type	Output content MIME type
	 * @return	string	Minified output
	 */
	static function minify($output, $type = 'text/html')
	{
		switch ($type)
		{
			case 'text/html':

				if (($size_before = strlen($output)) === 0)
				{
					return '';
				}

				// Find all the <pre>,<code>,<textarea>, and <javascript> tags
				// We'll want to return them to this unprocessed state later.
				preg_match_all('{<pre.+</pre>}msU', $output, $pres_clean);
				preg_match_all('{<code.+</code>}msU', $output, $codes_clean);
				preg_match_all('{<textarea.+</textarea>}msU', $output, $textareas_clean);
				preg_match_all('{<script.+</script>}msU', $output, $javascript_clean);

				// Minify the CSS in all the <style> tags.
				preg_match_all('{<style.+</style>}msU', $output, $style_clean);
				foreach ($style_clean[0] as $s)
				{
					$output = str_replace($s, self::_minify_script_style($s, TRUE), $output);
				}

				// Minify the javascript in <script> tags.
				foreach ($javascript_clean[0] as $s)
				{
					$javascript_mini[] = self::_minify_script_style($s, TRUE);
				}

				// Replace multiple spaces with a single space.
				$output = preg_replace('!\s{2,}!', ' ', $output);

				// Remove comments (non-MSIE conditionals)
				$output = preg_replace('{\s*<!--[^\[<>].*(?<!!)-->\s*}msU', '', $output);

				// Remove spaces around block-level elements.
				$output = preg_replace('/\s*(<\/?(html|head|title|meta|script|link|style|body|table|thead|tbody|tfoot|tr|th|td|h[1-6]|div|p|br)[^>]*>)\s*/is', '$1', $output);

				// Replace mangled <pre> etc. tags with unprocessed ones.

				if ( ! empty($pres_clean))
				{
					preg_match_all('{<pre.+</pre>}msU', $output, $pres_messed);
					$output = str_replace($pres_messed[0], $pres_clean[0], $output);
				}

				if ( ! empty($codes_clean))
				{
					preg_match_all('{<code.+</code>}msU', $output, $codes_messed);
					$output = str_replace($codes_messed[0], $codes_clean[0], $output);
				}

				if ( ! empty($textareas_clean))
				{
					preg_match_all('{<textarea.+</textarea>}msU', $output, $textareas_messed);
					$output = str_replace($textareas_messed[0], $textareas_clean[0], $output);
				}

				if (isset($javascript_mini))
				{
					preg_match_all('{<script.+</script>}msU', $output, $javascript_messed);
					$output = str_replace($javascript_messed[0], $javascript_mini, $output);
				}

				$size_removed = $size_before - strlen($output);
				$savings_percent = round(($size_removed / $size_before * 100));

				 

			break;

			case 'text/css':
			case 'text/javascript':

				$output = self::_minify_script_style($output);

			break;

			default: break;
		}

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Minify Style and Script
	 *
	 * Reduce excessive size of CSS/JavaScript content.  To remove spaces this
	 * script walks the string as an array and determines if the pointer is inside
	 * a string created by single quotes or double quotes.  spaces inside those
	 * strings are not stripped.  Opening and closing tags are severed from
	 * the string initially and saved without stripping whitespace to preserve
	 * the tags and any associated properties if tags are present
	 *
	 * Minification logic/workflow is similar to methods used by Douglas Crockford
	 * in JSMIN. http://www.crockford.com/javascript/jsmin.html
	 *
	 * KNOWN ISSUE: ending a line with a closing parenthesis ')' and no semicolon
	 * where there should be one will break the Javascript. New lines after a
	 * closing parenthesis are not recognized by the script. For best results
	 * be sure to terminate lines with a semicolon when appropriate.
	 *
	 * @param	string	$output		Output to minify
	 * @param	bool	$has_tags	Specify if the output has style or script tags
	 * @return	string	Minified output
	 */
	static function _minify_script_style($output, $has_tags = FALSE)
	{
		// We only need this if there are tags in the file
		if ($has_tags === TRUE)
		{
			// Remove opening tag and save for later
			$pos = strpos($output, '>') + 1;
			$open_tag = substr($output, 0, $pos);
			$output = substr_replace($output, '', 0, $pos);

			// Remove closing tag and save it for later
			$end_pos = strlen($output);
			$pos = strpos($output, '</');
			$closing_tag = substr($output, $pos, $end_pos);
			$output = substr_replace($output, '', $pos);
		}

		// Remove CSS comments
		$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!i', '', $output);

		// Remove spaces around curly brackets, colons,
		// semi-colons, parenthesis, commas
		$output = preg_replace('!\s*(:|;|,|}|{|\(|\))\s*!i', '$1', $output);

		// Replace tabs with spaces
		// Replace carriage returns & multiple new lines with single new line
		// and trim any leading or trailing whitespace
		$output = trim(preg_replace(array('/\t+/', '/\r/', '/\n+/'), array(' ', "\n", "\n"), $output));

		// Remove spaces when safe to do so.
		$in_string = $in_dstring = $prev = FALSE;
		$array_output = str_split($output);
		foreach ($array_output as $key => $value)
		{
			if ($in_string === FALSE && $in_dstring === FALSE)
			{
				if ($value === ' ')
				{
					// Get the next element in the array for comparisons
					$next = $array_output[$key + 1];

					// Strip spaces preceded/followed by a non-ASCII character
					// or not preceded/followed by an alphanumeric
					// or not preceded/followed \ $ and _
					if ((preg_match('/^[\x20-\x7f]*$/D', $next) OR preg_match('/^[\x20-\x7f]*$/D', $prev))
						&& ( ! ctype_alnum($next) OR ! ctype_alnum($prev))
						&& ! in_array($next, array('\\', '_', '$'), TRUE)
						&& ! in_array($prev, array('\\', '_', '$'), TRUE)
					)
					{
						unset($array_output[$key]);
					}
				}
				else
				{
					// Save this value as previous for the next iteration
					// if it is not a blank space
					$prev = $value;
				}
			}

			if ($value === "'")
			{
				$in_string = ! $in_string;
			}
			elseif ($value === '"')
			{
				$in_dstring = ! $in_dstring;
			}
		}

		// Put the string back together after spaces have been stripped
		$output = implode($array_output);

		// Remove new line characters unless previous or next character is
		// printable or Non-ASCII
		preg_match_all('/[\n]/', $output, $lf, PREG_OFFSET_CAPTURE);
		$removed_lf = 0;
		foreach ($lf as $feed_position)
		{
			foreach ($feed_position as $position)
			{
				$position = $position[1] - $removed_lf;
				$next = $output[$position + 1];
				$prev = $output[$position - 1];
				if ( ! ctype_print($next) && ! ctype_print($prev)
					&& ! preg_match('/^[\x20-\x7f]*$/D', $next)
					&& ! preg_match('/^[\x20-\x7f]*$/D', $prev)
				)
				{
					$output = substr_replace($output, '', $position, 1);
					$removed_lf++;
				}
			}
		}

		// Put the opening and closing tags back if applicable
		return isset($open_tag)
			? $open_tag.$output.$closing_tag
			: $output;
	}
}