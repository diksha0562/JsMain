function trim(inputString) {
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") { return inputString; }
   var retValue = inputString;
   var ch = retValue.substring(0, 1);
   while (ch == " ") { // Check for spaces at the beginning of the string
      retValue = retValue.substring(1, retValue.length);
      ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);
   while (ch == " ") { // Check for spaces at the end of the string
      retValue = retValue.substring(0, retValue.length-1);
      ch = retValue.substring(retValue.length-1, retValue.length);
   }
   while (retValue.indexOf("  ") != -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); // Again, there are two spaces in each of the strings
   }
   return retValue; // Return the trimmed string back to the user
} // Ends the "trim" function


function validate()
{

	$err='';
	
	
	if(trim(document.form1.subject.value)=="" ) 
	{
		$err+="Please enter the value of From Email\n";
	}
	alert("1");
	if(trim(document.form1.f_email.value)=="" ) 
	{
		$err+="Please enter the value of From Email\n";
	}
alert("2");
	if (document.form1.f_email.value.indexOf("@")==-1)
	 {
        $err+="Please enter a valid Email address\n";
	 }
	if(trim(document.form1.data.value)=="")
	{
		   $err+="Please enter a data for the mail\n";
	}
	alert("3");
	if($err != "")
	 {
	 alert("You forget to choose following.\n" + $err);
	 return false;
	 }	
	 return true;
}

