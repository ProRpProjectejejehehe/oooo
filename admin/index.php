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
if(empty($arbb->input['action']))
{

die('<FRAMESET border=0 frameSpacing=0 frameBorder=0 cols=195,*>
<FRAME border=no name=nav marginWidth=0 marginHeight=0 src="index.php?action=menu" frameBorder=0 scrolling=yes>
<FRAMESET border=0 frameSpacing=0 rows=20,* frameBorder=0>
<FRAME border=no name="head" marginWidth=10 marginHeight=0 src="index.php?action=head" frameBorder=0 noResize scrolling=no>
<FRAME border=no name="main" marginWidth=10 marginHeight=10 src="index.php?action=main" frameBorder=0 scrolling=yes>
</FRAMESET>
</FRAMESET>');

}
elseif($arbb->input['action']=="pass")
{
if($arbb->input['do']=="edit")
{
$password=md5($arbb->input['newpass']);
setcookie('cookie_password',$password,time()+36000);
$query=$DB->query("update admin set password='$password'");
redirect('�� ����� ���� ������ ����� .. ����� ������� ���� ������ ������� ��� ����� ������ �� ����� �������','index.php');
}
else
{
$webcontent.='<p><br>
&nbsp;</p>
<form action="index.php?action=pass&do=edit" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">����� ���� ������ ������ ������� �����</td>
        </tr>

        <tr>
          <td class="td2" align="middle" colSpan="2">������ : ����� ���� ������ �� ���� ��� ��� ��������..</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">���� ������ �������</td>
          <td class="td1" vAlign="top" width="60%"><input type=text name=newpass></td>
        </tr>
        <tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="����� ���� ������" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="����� �����" size="30"></td>
        </tr>
    </table>
    &nbsp;</form>';
}
}
elseif($arbb->input['action']=='logout')
{
setcookie('cookie_username','',time()-36000);
setcookie('cookie_password','',time()-36000);

redirect('�� ����� ������ �����','../index.php?s='.time().'');
}
elseif($arbb->input['action']=='menu')
{
$webcontent='        <link href="default/controlpanel.css" type=text/css rel=stylesheet>
<br>
<div align="center">
���� ������<br>N3san.net
<br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
  <TR vAlign=top align="center" class=tcat>
    <TD><a href="index.php?action=pass" target="main">����� ���� ������</a></TD>
  </TR>

</TABLE>

<br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
<tbody>
<tr>
<td class="thead" align="center">������ ��������</td>
</tr>
</tbody>
<tbody>
<tr>
<td class="td1"><a href="cat.php?action=add" target="main">����� ���</a></td>
</tr><tr>
<td class="td1"><a href="cat.php?action=edit" target="main">����� ���</a></td>
</tr><tr>
<td class="td1"><a href="cat.php?action=del" target="main">��� ���</a></td>
</tr>
</tbody>
</table>
<br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
<tbody>
<tr>
<td class="thead" align="center">������ ��������</td>
</tr>
</tbody>
<tbody>
<tr>
<td class="td1"><a href="maq.php?action=add" target="main">����� ����</a></td>
</tr><tr>
<td class="td1"><a href="maq.php?action=edit" target="main">����� ����</a></td>
</tr><tr>
<td class="td1"><a href="maq.php?action=del" target="main">��� ����</a></td>
</tr>
</tbody>
</table>


</div>
<br><br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
  <TR vAlign=top align="left" class=tcat>
    <TD class="smallfont" style="TEXT-ALIGN: center"><A href="../index.php" target=_blank>��������</A> | <A href="index.php?action=logout" target=_top>����� ������</A>
    </TD>
  </TR>

</TABLE>';

}
elseif($arbb->input['action']=='main')
{

$webcontent='        <link href="default/controlpanel.css" type=text/css rel=stylesheet>
<br>
<div align="center">
����� �� �� ���� ������<br><br>
<br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
  <TR vAlign=top align="center" class=tcat>
    <TD><a href="index.php?action=pass" target="main">����� ���� ������</a></TD>
  </TR>

</TABLE>

<br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
<tbody>
<tr>
<td class="thead" align="center">���� ����� �� �� ���� ������</td>
</tr>
</tbody>
<tbody>
<tr>
<td class="td1">���� ������ ����� �� ������ �������� .. ��� ����� ����� ����� �� ����� ������� ������� ��� �������� ����� ..</td>
</tr><tr>
</tbody>
</table>


</div>
<br><br>
<table class="table_border"  cellpadding="3" cellspacing="1" border="0" width="95%" align="center">
  <TR vAlign=top align="left" class=tcat>
    <TD class="smallfont" style="TEXT-ALIGN: center"><A href="../index.php" target=_blank>��������</A> | <A href="index.php?action=logout" target=_top>����� ������</A>
    </TD>
  </TR>

</TABLE>';

}
elseif($arbb->input['action']=='head')
{
$webcontent='<LINK href="default/controlpanel.css" type=text/css rel=stylesheet>

<TABLE height="100%" width="100%" border="0">
  <TR vAlign=top align="left">
    <TD class="smallfont"><B>���� ������</B> N3san Tube</TD>
    <TD>
    </TD>
    <TD class="smallfont" style="TEXT-ALIGN: right"><A href="../index.php" target=_blank>��������</A> | <A href="index.php?action=logout" target=_top>����� ������</A>
    </TD>
  </TR>

</TABLE>';
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

if($arbb->input['action']=='login')
{
$usn=$arbb->input['username'];
$usp=md5($arbb->input['password']);
$query=$DB->query("select * from admin where name='$usn' and password='$usp'");
if($DB->num_rows($query)>0)
{
setcookie('cookie_username',$usn,time()+36000);
setcookie('cookie_password',$usp,time()+36000);

redirect('�� ����� ������ �����','index.php?s='.time().'');
}
}
print_page();
?>
