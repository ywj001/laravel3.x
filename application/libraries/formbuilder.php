<?php
/**
 * 生成表单
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class formbuilder{
	static $name = '_token_id_';//node custom type name
	static $form_fx = '_token_node_'; //
	static $validate_form_id = '_mincms_validateions_'; // 
	public $update = 'update'; //更新div 的id
	public $validations;
	public $type;
	public $form_id = 'form';
	public $js;//成功后JS用户可自行添加
	public $info;
	public $post;
	public $id_update = false;
	public $object;
	public $hidden;
	 
	static function load($name,$file,$nid=null){
		$yaml = path('app').'forms'.DS.$file.'.yaml';
		$php  =  path('app').'forms'.DS.$file.'.php';
		if(file_exists($php)){
			$load = $php; 
		}
		if(file_exists($yaml)){
			$load = $yaml;

		}
		$data = Spyc::YAMLLoad($yaml);  
		$form = static::open($name,$nid);
	 
		if(!$data) return; 

		foreach ($data as $key => $value) {
			$h = $value['element'];
			if(!$h) continue;
			$label = $value['label'];  
			$parms['plugins'] = $value['plugins']; 
			$parms['validation'] = $value['validation']; 
			$parms['options'] = $value['options']; 
			if($label)
				$html[$key.'#label'] = $form->lable($label);
			$html[$key] = $form->$h($key,$parms); 
		}
		$form->object = $html;
		return $form; 
	}
	
	function render($url=null){
		foreach ($this->object as $v) {
			echo "<p>".$v."</p>";
		}
		echo $this->close($url); 
	}
	public function file($name,$array=null){ 
		$f['value'] = $name;
		$one = $this->post; 
		$max_file_size = $array['max']?:'10mb';
		$ext = $array['ext']?:'jpg,gif,png';

		include __DIR__.'/formbuilder_file.php';
	}

	static function array_to_rules($array){
		foreach ($array as $k => $v) {
			if($v===true || $v===false){
				$rule .=$k.'|';
			}else{
				$rule .=$k.":$v|";
			}
		}
		if(substr($rule,-1)=='|')
			$rule = substr($rule, 0,-1);
		return $rule;
	}
	static function get_validations($flag=true){ 
		if (!Request::ajax()) exit('Roboot'); 
		$input = Input::all();
		$name = decode($input[static::$name]);
		if($input[static::$validate_form_id]){
			$validates = static::decode($input[static::$validate_form_id]);
		 	//dump($validates);
		 	foreach ($validates as $key => $value) { 
		 		$rules[$key] = static::array_to_rules($value);
		 	}  
		} 
		if(\CMS::array_len($rules)<1)
			$rules = Node::fields_rules($name);
	 
		unset($input['csrf_token'],
			$input[static::$name],
			$input[static::$validate_form_id]);
		if(implode('',array_values($rules))){ 
			$rt = Validator::make($input, $rules);    
			if ($rt->fails())
			{ 
			    return $rt->errors; 
			}
		}
		if(false === $flag)
			return $input;
	}
	static function validate(){
		$input = static::get_validations(false);
		if(is_object($input)){
		 	$errors = $input->all('<p>:message</p>');
		    foreach ($errors as $value) {
		    	$out .=$value;
		    }
		    return "<div class='alert alert-error'>".$out."</div>";
		} 
	}
	static function save($datas=array()){  
		$uid = 0;
		$input = static::get_validations(false);
		if(is_object($input)){
		 	$errors = $input->all('<p>:message</p>');
		    foreach ($errors as $value) {
		    	$out .=$value;
		    }
		    return "<div class='alert alert-error'>".$out."</div>";
		} 
		$all = Input::all();
		$name = decode($all[static::$name]); 
		if($datas) {
			foreach ($datas as $key => $value) {
				$input[$key] = $value;
			}
		}
		 
		$t = Node::save($name,$input);
		if($t)
			return 1;
		else
			return 0;
	}		

	public function _plugin($plugins,$op){
		if($plugins){
			foreach ($plugins as $key => $value) {
				$ops = array_merge($value,$op);
				plugin($key,$ops);
			}
		}

	}
	protected function _with($type,$name,$array=null){  
		$value = $this->post->$name; 
		$form = Form::$type($name,$value,array('id'=>static::$form_fx.$name));
		$this->form_plugin_validate($name,$array[1]); 
		return  $form;
	}
	protected function form_plugin_validate($name,$array){ 
		if($array['plugins']){
			$this->_plugin($array['plugins'],array('tag'=>static::$form_fx.$name));
		} 
		if($array['validation']){
			$this->validations[$name] = $array['validation'];
		}
	}
	public function submit($value='Submit',$op=null){
		if($op['options']) $ee = $op['options'];
		else $ee = array('class'=>'btn');
		foreach($ee as $k=>$v){
			$e .= $k."='".$v."' ";
		}
		$form = "<input type='submit' value='".__("front.$value")."' $e >";
		return $form;
	}	

	public function lable($name,$for=null){ 
		$name = __("front.$name");
		return "<label>$name</label>";
	}
	public function hidden($name,$value){
		return Form::hidden($name,$value); 
	}
	static function open($name,$nid=0){
		$obj = new formbuilder;
		$form = Form::open(null,null,array('id'=>$obj->form_id)).Form::token(); 
		$form .= Form::hidden(static::$name,encode($name)); 
		$obj->type = $name;
		$obj->info = __('admin.create success');
		if($nid>0){
			$obj->id_update = true;
			$obj->post = node($name,$nid);  
			if($obj->post)
				$form .= Form::hidden('id',encode($obj->post->id));  
			$obj->info = __('admin.update success');
		}
   		assets("misc/jquery/jquery.form.js"); 
		echo $form;
		return $obj;
	}	

	public function close($url=null){  
		if($this->validations){
			$validates = static::encode($this->validations);
		}
		if(!$url) $url = action('api/node/save');
 
	if($this->id_update === false){
		$clearForm = "$('".$this->form_id."').clearForm();
	    		$('".$this->form_id." .file').remove();";
	    	}
	CMS::script('formbuilder_'.$this->type,"
	formbuilder_ajax_form();
	function formbuilder_ajax_form(){
		$('".$this->form_id."').ajaxForm({ 
		    target: '#".$this->update."', 
			type: 'post', 
			url: '".$url."',
			beforeSend: function(arr) { 
			    $('".$this->form_id." button[type=\"submit\"]').attr('disabled','disabled');
			},
		    success: function(data) {  
		    	if(data==1){  
		    		".$clearForm."
		    		$('#".$this->update."').html('".$this->info."').css('color','#b94a48').fadeIn('slow') 
		        		.animate({opacity: 1.0}, 5000);
		        	".$this->js."
		        	formbuilder_ajax_form();
		        	return false;
		    	}if(data==0){
		    		$('#".$this->update."').html('".__('admin.save failed')."').css('color','#b94a48').fadeIn('slow') 
		        		.animate({opacity: 1.0}, 5000);	 
		        	return false;
		    	}else{
		    		$('button[type=\"submit\"]').removeAttr('disabled');
	    			$('#".$this->update."').html(data).css('color','#b94a48').fadeIn('slow') 
	        		.animate({opacity: 1.0}, 5000); 
		    		return false;
		    	}
		    	formbuilder_ajax_form();
		        
		    } 
		});  
		}
	");
 
 
		$form .= Form::hidden(static::$validate_form_id,$validates);
		if($this->hidden){
			if(is_array($this->hidden)){
				foreach($this->hidden as $k=>$v){
					$form .= Form::hidden($k,$v); 
				}
			} 
		}
		$form .= Form::close();
		return $form;
	}	
	public function __call($method, $parameters)
	{
		$name = $parameters[0];
		unset($parameters[0]);
		return $this->_with($method,$name,$parameters);
		 
	}
	static function encode($values){
		return encode(serialize($values));
	}
	static function decode($values){
		return unserialize(decode($values));
	}


}