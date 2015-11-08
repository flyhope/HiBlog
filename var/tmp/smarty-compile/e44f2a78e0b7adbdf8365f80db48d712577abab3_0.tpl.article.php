<?php /* Smarty version 3.1.27, created on 2015-11-09 00:35:50
         compiled from "tpl:article" */ ?>
<?php
/*%%SmartyHeaderCode:27751563f79e6cb51e6_56875877%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e44f2a78e0b7adbdf8365f80db48d712577abab3' => 
    array (
      0 => 'tpl:article',
      1 => 1447000550,
      2 => 'tpl',
    ),
  ),
  'nocache_hash' => '27751563f79e6cb51e6_56875877',
  'variables' => 
  array (
    'var' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_563f79e6ce4ed8_19551595',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_563f79e6ce4ed8_19551595')) {
function content_563f79e6ce4ed8_19551595 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '27751563f79e6cb51e6_56875877';
?>
<b>test</b>
<i><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['var']->value, ENT_QUOTES, 'UTF-8', true);?>
</i><?php }
}
?>