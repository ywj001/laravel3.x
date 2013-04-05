<?php
 
class Validator extends Laravel\Validator {

    public function validate_mincms_table_vali($attribute, $value, $parameters)
    {   
        if(in_array($value, array(
            'id','created','updated','uid','sort'
        ))) return false;
        return true;
    }
	public function validate_node_unique($attribute, $value, $parameters)
    {   
    	$table = $parameters[0];
    	$fid = $parameters[1];
    	$id = $parameters[2]; 
    	$row = DB::table($table)->where('field_id','=',$fid)->where('value','=',$value)->first();  
     	if(!$row) return true;
     	if($id){  
     		if($row->id!=$id) return false;  
     	}  
    	return true; 
    }
	
	
 	public function validate_taxonomy($attribute, $value, $parameters)
    {  
     	$pid = (int)$_POST['pid']?:0; 
     	$post = DB::table('taxonomy')->where('pid','=',$pid)->where('name','=',$value)->first();  
     	if(!$post) return true;
      	if($parameters[0]) $id = $parameters[0];
      	if($id){
      		return $post->id ==$id?true:false;
      	}
        return $post->name==$value?false:true;
    }
 	public function validate_pid_value($attribute, $value, $parameters)
    { 
     	$table = trim($parameters[0]);
     	if(!$table) return false; 
     	$post = DB::table($table)->where('value','=',$value)->where('pid','=',0)->first();  
        return $post?false:true;
    }
    
 	/**
 	* 'old_password'  => "required|max:20|old_password:$id",	 
 	*/
    public function validate_old_password($attribute, $value, $parameters)
    { 
     	$id = (int)$parameters[0];
     	if(!$id) return false;
     	$user = DB::table('users')->where('id','=',$id)->first();
        return Hash::check(trim($value), $user->password);
    }
 
}