<?php
include "globals.php";
include 'admin/functions.php';
$loggedin=false;
$usn=$arbb->input['cookie_username'];
$usp=$arbb->input['cookie_password'];
if(strlen($usp)>10)
{
$query=$DB->query("select * from admin where name='$usn' and password='$usp'");
if($DB->num_rows($query)>0)
{

$loggedin=true;
}
}
if($loggedin == true)
{
 if($arbb->input['action']=='add')
 {
  if($arbb->input['do']=='add')
  {
   $ar=array('cat_id','title','url');
   foreach($ar as $key => $val)
   {
    $array[$val]=$arbb->input[$val];
   }
   $array['date']=time();
   $query=$DB->insert($array,'movies');
   $idd=$DB->insert_id();
   $id_d="$idd";
   $ext=strtolower(substr(strrchr($_FILES['pic']['name'], '.'), 1));
   move_uploaded_file($_FILES['pic']['tmp_name'],GETCWD()."/videos/images/$id_d.$ext");

      $DB->query("update movies set pic='$id_d.$ext' where id='$id_d'");
   redirect('�� ����� ������ ������ �����','maq.php?action=edit');
  }
  else
  {
$webcontent='<p><br>
&nbsp;</p>
<form enctype="multipart/form-data" action="maq.php?action=add&do=add" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">����� ����</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">����� ������</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32" value=""></td>
        </tr>';

$query=$DB->query("select * from cat order by id asc");
while($cat=$DB->fetch_array($query))
{
$options.="<option value='".$cat['id']."'>".$cat['title']."</option>";
}
$webcontent.='<tr>
          <td class="td1" vAlign="top" width="40%">�����</td>
          <td class="td1" vAlign="top" width="60%"><select name="cat_id">'.$options.'</select></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">��� ������..<br>������ : ��� ��� ������ ������� ����� videos/video ���� flv</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="url" size="32" value=""></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">����� ���� ������<br>������ : ������ ������ ��� �� ���� : <br>��� 125 ���� ������� 100 ����</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="file" name="pic" size="32" value=""></td>
        </tr>
        <tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="�����" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="����� �����" size="30"></td>
        </tr>
    </table>
    &nbsp;</form>
';
   }
 }
 elseif($arbb->input['action']=='edit')
 {
   if(empty($arbb->input['do']))
   {
  $query=$DB->query("select * from cat where 1=1 order by id asc");
$webcontent='<p><br>
&nbsp;</p>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="3">������ ��������</td>
        </tr>';

while($cat = $DB->fetch_array($query))
{
$webcontent.='        <tr>
          <td class="td1" vAlign="top" width="40%">'.$cat['title'].'</td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=edit&do=edit&id='.$cat['id'].'">����� �����</a></td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=del&do=del&id='.$cat['id'].'">��� �����</a></td>
        </tr> ';
}
$webcontent.='        <tr class="tcat">
      <td width="50%" align="center" colspan=3>&nbsp;</td>
        </tr>
    </table>
    &nbsp;
';
    }
    elseif($arbb->input['do']=='edit')
    {
      $query=$DB->query("select c.*,m.* from cat c left join movies m on (m.cat_id=c.id) where m.cat_id='".$arbb->input['id']."'");
$webcontent='<p><br>
&nbsp;</p>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="3">������ ��������</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">����� ������</td>
          <td class="td2" vAlign="top" width="30%">�����</td>
          <td class="td2" vAlign="top" width="30%">���</td>
        </tr>
        ';

while($m = $DB->fetch_array($query))
{
$webcontent.='        <tr>
          <td class="td1" vAlign="top" width="40%">'.$m['title'].'</td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=edit&do=edit_m&id='.$m['id'].'">����� ������</a></td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=del&do=del_m&id='.$m['id'].'">��� ������</a></td>
        </tr> ';
}
$webcontent.='        <tr class="tcat">
      <td width="50%" align="center" colspan=3>&nbsp;</td>
        </tr>
    </table>
    &nbsp;
';
    }
    elseif($arbb->input['do']=='edit_m')

    {
$query=$DB->query("select * from movies where id='".$arbb->input['id']."'");
while($m=$DB->fetch_array($query))
{
$webcontent='<p><br>
&nbsp;</p>
<form action="maq.php?action=edit&do=do_edit" method="post">
<input type="hidden" name="id" value="'.$m['id'].'">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">����� ������ : '.$m['title'].'</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">����� ������</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32" value="'.$m['title'].'"></td>
        </tr>';

$query=$DB->query("select * from cat order by id asc");
while($cat=$DB->fetch_array($query))
{
$selected=($cat['id']==$m['cat_id'])?" selected":"";
$options.="<option value='".$cat[id]."'$selected>".$cat[title]."</option>";
}
$webcontent.='<tr>
          <td class="td1" vAlign="top" width="40%">�����</td>
          <td class="td1" vAlign="top" width="60%"><select name="cat_id">'.$options.'</select></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">���� ������</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="url" size="32" value="'.$m['url'].'"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">���� ���� ������</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="pic" size="32" value="'.$m['pic'].'"></td>
        </tr>
        <tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="����� ������" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="����� �����" size="30"></td>
        </tr>
    </table>
    &nbsp;</form>
';
}
    }

    elseif($arbb->input['do']=='do_edit')
    {
      $tid=$arbb->input['id'];

   $ar=array('cat_id','title','url','pic');
   foreach($ar as $key => $val)
   {
    $array[$val]=$arbb->input[$val];
   }
      $DB->update($array,'movies','id='.$tid.'');
      redirect('�� ����� ������ �����','maq.php?action=edit&do=edit&id='.$m['cat_id'].''.time().'');
    }

 }
 elseif($arbb->input['action']=='del')
 {
   if(empty($arbb->input['do']))
   {
  $query=$DB->query("select * from cat where 1=1 order by id asc");
$webcontent='<p><br>
&nbsp;</p>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="3">������ ��������</td>
        </tr>';

while($cat = $DB->fetch_array($query))
{
$webcontent.='        <tr>
          <td class="td1" vAlign="top" width="40%">'.$cat['title'].'</td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=edit&do=edit&id='.$cat['id'].'">����� �����</a></td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=del&do=del&id='.$cat['id'].'">��� �����</a></td>

        </tr> ';
}
$webcontent.='        <tr class="tcat">
      <td width="50%" align="center" colspan=3>&nbsp;</td>
        </tr>
    </table>
    &nbsp;
';
    }
        elseif($arbb->input['do']=='del')
    {
      $query=$DB->query("select c.*,m.* from cat c left join movies m on (m.cat_id=c.id) where m.cat_id='".$arbb->input['id']."'");
$webcontent='<p><br>
&nbsp;</p>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="3">������ ��������</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">����� ������</td>
          <td class="td2" vAlign="top" width="30%">�����</td>
          <td class="td2" vAlign="top" width="30%">���</td>
        </tr>
        ';

while($m = $DB->fetch_array($query))
{
$webcontent.='        <tr>
          <td class="td1" vAlign="top" width="40%">'.$m['title'].'</td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=edit&do=edit_m&id='.$m['id'].'">����� ������</a></td>
          <td class="td1" vAlign="top" width="30%"><a href="maq.php?action=del&do=del_m&id='.$m['id'].'">��� ������</a></td>
        </tr> ';
}
$webcontent.='        <tr class="tcat">
      <td width="50%" align="center" colspan=3>&nbsp;</td>
        </tr>
    </table>
    &nbsp;
';
    }
    elseif($arbb->input['do']=='del_m')
    {
      $query=$DB->query("select * from movies where id='".$arbb->input['id']."'");
      while($m=$DB->fetch_array($query))
      {
$webcontent='<p><br>
&nbsp;</p>
<form action="maq.php?action=del&do=do_del" method="post">
<input type=hidden name=id value="'.$m['id'].'">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">��� : '.$m['title'].'</td>
        </tr>

        <tr>
          <td class="td2" align="middle" colSpan="2">�� ��� ����� �� ��� ���� ��� ������ �� . ������ : ����� ����� ����� �� ���� ������� ���� .. ���� ����� �� ��� ��� ��� ������ �� ������ ������ �� ����� ���� �� ����� �������� ���</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">����� ������</td>
          <td class="td1" vAlign="top" width="60%">'.$m['title'].'</td>
        </tr>
        <tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="��� ����� .. �� ������" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="����� �����" size="30"></td>
        </tr>
    </table>
    &nbsp;</form>
';
             }
    }

    elseif($arbb->input['do']=='do_del')
    {
      $tid=$arbb->input['id'];
      $DB->query("delete from movies where id='$tid'");
      redirect('�� ����� �����','maq.php?action=del&do=del&s='.time().'');
    }
 }
}
else
{
$webcontent = '<br>
      <form action="index.php?action=login" method="post">
        <table  class="table_border" cellpadding="6" cellspacing="1" border="0" align="center" width="50%">
          <tr class="tcat">
            <td align="left" colspan="2"><b>Login</b></td>
          </tr>
          <tr class="td2">
            <td align="left" colspan="2"><b>����� ������ : N3san.net</b></td>
          </tr>
          <tr class="td1">
            <td>��� ��������</td>
            <td><input size="35" name="username" value=""></td>
          </tr>
          <tr  class="td1">
            <td>���� ������</td>
            <td><input type="password" size="35" value name="password"></td>
          </tr>
          <tr class="td2">
            <td align="left" colspan="2"><b>�� ���� ���� ��������� ����� ��� �������</b></td>
          </tr>
          <tr class="thead">
            <td align="middle" colSpan="2">
            <input class="input-button" type="submit" value=" - - ����� ������ - - "></td>
          </tr>
        </table>
      </form>
';
$title='���� ������';
}


print_page();
?>
