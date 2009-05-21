<?php
/**
 * @package extrawords
 * @author Roamfox(roamfox@gmail.com)
 * @version 1.0
 */
/*
Plugin Name: Roamfox extra options
Plugin URI: http://roamfox.com/
Description: The template author can save settings in this plugin.Any question please feel free to contact roamfox@gmail.com,or visit my website http://www.roamfox.com.
Author: roamfox(roamfox@gmail.com)
Version: 1.0
Author URI: http://roamfox.com/
*/

$options_file = dirname(__FILE__).'/options.xml';

function init_dom()
{
	global $options_file;	
	$dom = new DOMDocument("1.0");
	if(!file_exists($options_file))
	{
		$dom->formatOutput = true;
		$root = $dom->createElement('xml');
		$root = $dom->appendChild($root);
		
		$item = $dom->createElement('option');
		$item->setAttribute('name','option1');
		$item->setAttribute('description','option1 des');
		$item->setAttribute('content','option1 content');
		$item = $root->appendChild($item);

		$dom->save($options_file);
	}
    $dom -> load($options_file);
    return $dom;
}

function update_dom($name,$new_name,$content,$decription)
{
	global $options_file;	
	$dom = new DOMDocument("1.0");
	$dom->formatOutput = true;
	$dom->load($options_file);
	$options = $dom -> getElementsByTagName("option");
	
	$i=0;
	
	if(!get_magic_quotes_gpc())
	{
		$name=stripcslashes($name);
		$new_name= stripcslashes($new_name);
		$content = stripcslashes($content);
		$decription=stripcslashes($decription);
		
	}
	
	//update
	foreach ($options as $v)
	{
		if($v->getAttribute('name')==$name)
		{
			$v->setAttribute('name',$new_name);
			$v->setAttribute('description',roamfox_encode($decription));
			$v->setAttribute('content',roamfox_encode($content));
			$i++;
		}
		
		$dom->save($options_file);
		
	}
	
	if(!$i) //add
	{
		$new_option = $dom->createElement('option');
		$new_option = $dom->getElementsByTagName('xml')->item(0)->appendChild($new_option);
		$new_option->setAttribute('name',$new_name);
		$new_option->setAttribute('description',roamfox_encode($decription));
		$new_option->setAttribute('content',roamfox_encode($content));
		$dom->save($options_file);
		
	}
}

function delete_dom($name)
{
	global $options_file;	
	$dom = new DOMDocument("1.0");
	$dom->formatOutput = true;
	$dom->load($options_file);
	$options = $dom -> getElementsByTagName("option");
	
	foreach ($options as $v)
	{
		if($v->getAttribute('name')==$name)
		{
			$dom->getElementsByTagName('xml')->item(0)->removeChild($v);
		}
		$dom->save($options_file);
	}
}

/*encode and decode*/
function roamfox_encode($str)
{
	return htmlentities($str,ENT_QUOTES,'UTF-8');
}

function riahtml_decode($str)
{
	return html_entity_decode($str,ENT_QUOTES,'UTF-8');
}


function wp_extrawords_options()
{
	$dom = init_dom();
	
	if($_POST['update_dom'])
	{
		if(!$_POST['delete_dom'])
		{
			$message='Update Success';
			update_dom($_POST['name'],$_POST['name'],$_POST['content'],$_POST['description']);
			echo '<div class="updated"><strong><p>'. $message . '</p></strong></div>';
		}else{
			$message='Delete Success';
			delete_dom($_POST['name']);
			echo '<div class="updated"><strong><p>'. $message .'</p></strong></div>';
		}
	}
	
	if($_POST['add_to_dom'])
	{
		$message='Add Success';
		update_dom($_POST['name'],$_POST['name'],$_POST['content'],$_POST['description']);
		echo '<div class="updated"><strong><p>'. $message . '</p></strong></div>';
	}
	$dom = init_dom();
	
    $options = $dom -> getElementsByTagName("option");

   
    

?>

<?php
	 foreach ($options as $v)
	    {
?>
<script type="text/javascript">
function delete_flag(name)
{
	document.getElementById('delete_flag_'+name).setAttribute('value','1');
}
</script>
<form action="" method="post" id="form_<?php echo $v ->getAttribute('name'); ?>">
	<input type="hidden" name="update_dom" value="1"/>
	<input type="hidden" name="delete_dom" value="0" id="delete_flag_<?php echo $v ->getAttribute('name'); ?>"/>
	
	<input type="hidden" name="name" value="<?php echo $v ->getAttribute('name'); ?>"/>
	<input type="hidden" name="description" value="<?php echo riahtml_decode($v ->getAttribute('description')); ?>"/>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row" width="15%"><label for="<?php echo $v-> getAttribute("name");?>"><?php echo $v-> getAttribute("name");?></label></th>
				<td width="35%"><input type="text" class="regular-text" value="<?php echo htmlspecialchars(riahtml_decode($v-> getAttribute("content")));?>" id="<?php echo $v-> getAttribute("name");?>" name="content"/></td>
				<td widht="35%"><?php if($v->hasAttribute('description')) echo '<span class="setting-description">'.riahtml_decode($v ->getAttribute('description')).'</span>'; ?></td>
				<td width="15%">
					<input type="submit" value="Update" class="button-primary" name="update"/>
					<input type="submit" value="Delete" class="button-primary" name="delete" onclick="delete_flag('<?php echo $v ->getAttribute('name'); ?>');"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<?php 
	    }
?>

<hr/>
<form action="" method="post">
	<input type="hidden" name="add_to_dom" value="1"/>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<td width="15%"><input type="text" class="regular-text" value="option<?php echo rand(100,2000); ?>" name="name" style="width:198px"/></td>
				<td width="35%"><input type="text" class="regular-text" value="Content of option" name="content"/></td>
				<td widht="35%"><input type="text" class="regular-text" value="Description" name="description"/></td>
				<td width="15%"><input type="submit" value="New Option" class="button-primary" name="Submit"/></td>
			</tr>
		</tbody>
	</table>
</form>
<?php
}

function roamfox_options_admin(){
	add_options_page('Admin_extrawords_authrized by www.roamfox.com', 'Roamfox Extra  Options', 5,  __FILE__, 'wp_extrawords_options');
}
add_action('admin_menu','roamfox_options_admin');


//fetch data

function roamfox_fetch_option_content($option_name)
{

	global $options_file;	
	$dom = new DOMDocument("1.0");
	$dom->load($options_file);
	$options = $dom -> getElementsByTagName("option");
	foreach ($options as $v)
	{
		if($v->getAttribute('name')==$option_name)
		{
			return $v->getAttribute('content');	
		}
	}
	return false;
}
function roamfox_fetch_single_option($option_name)
{

	global $options_file;	
	$dom = new DOMDocument("1.0");
	$dom->load($options_file);
	$options = $dom -> getElementsByTagName("option");
	foreach ($options as $v)
	{
		if($v->getAttribute('name')==$option_name)
		{
			$option_data['name']=$option_name;
			$option_data['description']= $v->getAttribute('description');
			$option_data['content']= $v->getAttribute('content');
			return  $option_data;	
		}
	}
	return false;
}

function roamfox_fetch_options()
{

	global $options_file;	
	$dom = new DOMDocument("1.0");
	$dom->load($options_file);
	$options = $dom -> getElementsByTagName("option");
	$i=0;
	foreach ($options as $v)
	{
		$option_data[$i]['name']=$v->getAttribute('name');
		$option_data[$i]['description']= $v->getAttribute('description');
		$option_data[$i]['content']= $v->getAttribute('content');
		$i++;		
	}
	if(is_array($option_data))
	{
		return $option_data;
		
	}else{
		return false;
	}
}


?>
