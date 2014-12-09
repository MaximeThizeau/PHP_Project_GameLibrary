<?php
class Comment
{

	private $data = array();
	public function __construct($row)
	{
		$this->data = $row;
	}

	public function markup()
	{
		$d = &$this->data;
		$link_open = '';
		$link_close = '';
		return '

		<div id="contentavis">
		<div class="comment" >
		<div class="avatar">
		'.$link_open.'
		<img src="../assets/img/logoComment.png">
		'.$link_close.'
		<div class="name">'.$link_open.$d['name'].$link_close.'</div>
		<p>'.$d['body'].'</p></div>
		</div>
		</div>
		';
	}

	public static function validate(&$arr)
	{
		$errors = array();
		$data = array();

		if(!($data['game_id'] = filter_input(INPUT_POST,'game_id',FILTER_CALLBACK,array('options'=>'Comment::validate_text'))))
		{
			$errors['game_id'] = '*';
		}

		if(!($data['body'] = filter_input(INPUT_POST,'body',FILTER_CALLBACK,array('options'=>'Comment::validate_text'))))
		{
			$errors['body'] = '<span style="color:red;"></span>';
		}

		if(!($data['name'] = filter_input(INPUT_POST,'name',FILTER_CALLBACK,array('options'=>'Comment::validate_text'))))
		{
			$errors['name'] = '<span style="color:red;"></span>';
		}

		if(!empty($errors))
		{
			$arr = $errors;
			return false;
		}

		foreach($data as $k=>$v)
		{
			$arr[$k] = htmlspecialchars($v);
		}

		return true;
	}

	private static function validate_text($str)
	{
		if(mb_strlen($str,'utf8')<1)
		return false;
		$str = nl2br(htmlspecialchars($str));
		$str = str_replace(array(chr(10),chr(13)),'',$str);
		return $str;
	}
}
?>
