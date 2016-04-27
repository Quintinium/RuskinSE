<%@ Page Title="Home Page" Language="VB" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Default.aspx.vb" Inherits="WebApplication1._Default" %>

<asp:Content ID="BodyContent" ContentPlaceHolderID="MainContent" runat="server">

    <p>
        Everything realting to our search box will go here:</p>
    <asp:RadioButton ID="RadioButton1" runat="server" />
    <p>
        &nbsp;</p>
    <form>
 +		Keywords: <input type="text" placeholder="Search..." required><br/>
 +		<input type="checkbox">Include results appearing multiple times in same document<br/>
 +		<strong>Filters:</strong><br/><br/>
 +		<input type="checkbox">
 +		Date:<input type="text"> -
 +		<input type="text"><br/><br/>
 +		<input type="checkbox">Document type:
 +		<select name="Document type" size=1 value>
 +			<option name="Type" value="0"> All</option> 
 +			<option name="Type" value="1"> Notes </option> 
 +			<option name="Type" value="2"> Essays </option> 
 +			<option name="Type" value="3"> Manuscripts </option> 
 +			<option name="Type" value="4"> Poems </option>
 +		</select><br/><br/>
 +		<input type="checkbox">Author:
 +		<select name="Document type" size=1 value>
 +			<option name="Type" value="0"> All</option> 
 +			<option name="Type" value="1"> John Ruskin </option> 
 +			<option name="Type" value="2"> Margret Ruskin </option>
 +		</select><br/><br/>
 +		<input type="radio" name="Keyword" value="1"/> Keyword appears as any tag<br/>
 +					<input type="radio" name="Keyword1" value="2"/> Keyword is tagged as title of
 +					<select name="Document type" size=1 value>
 +			<option name="Type" value="0"> Anthology</option> 
 +			<option name="Type" value="1"> Artwork </option> 
 +			<option name="Type" value="2"> Book </option> 
 +		</select><br/><br/>
 +		<input type="radio" name="Keyword2" value="1"/> Keyword is tagged as title of
 +			<select name="Document type" size=1 value>
 +			<option name="Type" value="0"> Animal</option> 
 +			<option name="Type" value="1"> Constellation</option> 
 +			<option name="Type" value="2"> Place</option> 
 +		</select><br/><br/><br/>
 +		<input type="button" value="Search"><br/><br/>
 +	</form>
 +	<a href="https://blog.udemy.com/search-box-css/">Search bar website</a>

</asp:Content>
