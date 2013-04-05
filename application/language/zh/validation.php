<?php 

return array(
	'node_unique'=>'存在重复值',
	'taxonomy'=>'分类已存在',
	'pid_value'=>'存在重复值',
	'old_password'=>'原密码不正确',
	'mincms_table_vali'=>'系统内置字段不能添加',
	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/ 
	"accepted"       => "字段 :attribute 不接受当前值.",
	"active_url"     => "字段 :attribute 不是一个正确的URL.",
	"after"          => "字段 :attribute 必须是时间格式且时间在 :date 后.",
	"alpha"          => "字段 :attribute 必须是字母.",
	"alpha_dash"     => "字段 :attribute 必须是字母、数字、下划线.",
	"alpha_num"      => "字段 :attribute 必须由字母与数字组成.",
	"array"          => "字段 :attribute 必须选择一项.",
	"before"         => "字段 :attribute 必须是时间格式且时间在 :date 前.",
	"between"        => array(
		"numeric" => "字段 :attribute 必须在 :min - :max.",
		"file"    => "字段 :attribute 必须在 :min - :max 字节.",
		"string"  => "字段 :attribute 必须在 :min - :max 字符.",
	),
	"confirmed"      => "字段 :attribute 内容未被重复.",
	"count"          => "字段 :attribute 必须选择 :count 个.",
	"countbetween"   => "字段 :attribute 必须在 :min and :max 选定元素.",
	"countmax"       => "字段 :attribute 必须小于 :max 选定元素.",
	"countmin"       => "字段 :attribute 必须大于等于 :min 选定元素.",
	"date_format"	 => "字段 :attribute 必须是时间格式.",
	"different"      => "字段 :attribute 与 :other 不能重复.",
	"email"          => "字段 :attribute 格式不正确.",
	"exists"         => "字段 :attribute 的值无效.",
	"image"          => "字段 :attribute 必须是图片.",
	"in"             => "字段 :attribute 的值无效.",
	"integer"        => "字段 :attribute 字段是整数.",
	"ip"             => "字段 :attribute 必须是IP地址.",
	"match"          => "字段 :attribute 格式无效.",
	"max"            => array(
		"numeric" => "字段 :attribute 必须小于 :max.",
		"file"    => "字段 :attribute 必须大于等于 :max 字节.",
		"string"  => "字段 :attribute 必须大于等于 :max 字符.",
	),
	"mimes"          => "字段 :attribute 类型必须是: :values.",
	"min"            => array(
		"numeric" => "字段 :attribute 长度不小于 :min.",
		"file"    => "字段 :attribute 长度大于等于 :min 字节.",
		"string"  => "字段 :attribute 长度大于等于 :min 字符.",
	),
	"not_in"         => "字段 :attribute 的值无效.",
	"numeric"        => "字段 :attribute 必须是数字.",
	"required"       => "字段 :attribute 不能为空.",
    "required_with"  => "字段 :attribute 字段是必需的 :field",
	"same"           => "字段 :attribute 与 :other 必须重复.",
	"size"           => array(
		"numeric" => "字段 :attribute 必须 :size.",
		"file"    => "字段 :attribute 必须 :size 字节.",
		"string"  => "字段 :attribute 必须 :size 字符.",
	),
	"unique"         => "字段 :attribute 已经存在.",
	"url"            => "字段 :attribute 格式不正确.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);
