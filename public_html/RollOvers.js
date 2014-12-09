/*
	 This page is part of FestivalWare
	 Written by John Goetz and Claudia Bessette Goetz
	 Copyright (C) 2004 FestivalWare
*/
// JavaScript Document

function swapon1()  { document.img1.src="img/home_r.jpg"; }
function swapoff1() { document.img1.src="img/home.jpg"; }
function swapon2()  { document.img2.src="img/ContactUs_r.jpg"; }
function swapoff2() { document.img2.src="img/ContactUs.jpg"; }
function swapon3()  { document.img3.src="img/FAQ_r.jpg"; }
function swapoff3() { document.img3.src="img/FAQ.jpg"; }
function swapon4()  { document.img4.src="img/CommDesc_r.jpg"; }
function swapoff4() { document.img4.src="img/CommDesc.jpg"; }
function swapon5()  { document.img5.src="img/RegStudio_r.jpg"; }
function swapoff5() { document.img5.src="img/RegStudio.jpg"; }
function swapon6()  { document.img6.src="img/StudioAdmin_r.jpg"; }
function swapoff6() { document.img6.src="img/StudioAdmin.jpg"; }
function swapon7()  { document.img7.src="img/SchedPerf_r.jpg"; }
function swapoff7() { document.img7.src="img/SchedPerf.jpg"; }
function swapon8()  { document.img8.src="img/Timeline_r.jpg"; }
function swapoff8() { document.img8.src="img/Timeline.jpg"; }

function isblank(something)
{
	var c;
	for (var i=0; i < something.length; i++)
	{
		c = something.charAt(i);
		if( (c != ' ') && (c != '\n') && (c != '\t') )
			return false;
	}//end for each character
	return true;
}//end isblank

function checkPasswordEntries(first, second)
{
	if(isblank(first) || isblank(second))
	{
		alert("Please enter your new password twice!");
		return false;
	}
	else if(first != second )
	{
		alert("Your new passwords don't match!");
		return false;
	}
	else
	{
		return true;
	}
}

function isInteger(str){ 
// checks if the string arg contains only digits
	var digit;
	if(str.length == 0) // can't be an integer if there's nothing there... 
		return false;
	else 	// if any char is not a digit, return false
		for (digit = 0; digit < str.length; digit++) 
			if (str.charAt(digit) < "0" || str.charAt(digit) > "9") 
				return false;
	//at this point, all chars verified to be digits
	return true; 
}// end isInteger function


function checkReqEntries(which) {
	var msg = "";
	var empty_fields = "";
	var errors = "";
	var fullError = "";
	var password1 = ""; 
	var password2 = "";
	var checkEntry = false;

	for(var i=0; i<which.length; i++)
	{
		var e = which.elements[i];
		checkEntry = false;
			
		if("req" == e.name.substr(0,3) )// if required entry
		{
			if ( ( ("text" == e.type) || ("textarea" == e.type) || ("password" == e.type) ) && 
				( ("" == e.value) || (null == e.value) || isblank(e.value) ))  // required and blank
			{
				empty_fields += "\n   " + e.title;
				continue; // go to next field
			} // end if empty required field
			else
				checkEntry = true;
		}	
		else  // if optional field
		{
			if (("" == e.value) || (null == e.value) || isblank(e.value))  // if blank and not required
			{
				continue; // do nothing
			}
			else	// optional but not blank ==> check it for accuracy
			{
				checkEntry = true;
			}
		}

		if (checkEntry)  // if not blank, check for accuracy
		{
			// we know that password1 comes before password2, so we can use that to check only 
			// after password2  is reached.

			if(e.name.match(/Pwd1/g))
			{ 
				password1 = e.value;
				if(password1.length < 5)
					errors += "\nYour first password isn't long enough.";
			}
			else if(e.name.match(/Pwd2/g))
			{
				password2 = e.value;
				if(password2.length < 5)
					errors += "\nYour second password isn't long enough.";
				if(password1 != password2)
					errors += "\nYour passwords don't match.";
			}

			else if(e.name.match(/AgreeRules/g))
			{
				if(! e.checked)
					errors += "\n  You must agree to your festival rules before registering a student!";
				continue;
			}

			else if(e.name.match(/List/g))
			{
				if("-1" == e.value)
					empty_fields += "\n  " + e.title;
				continue;
			}
			else if(e.name.match(/Email/g))
			{
				var reg1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/; // not valid
  				var reg2 = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/; // valid
  				if (reg1.test(e.value) || !reg2.test(e.value))  // if syntax is NOT valid
				{
    				errors += "\nThe email address in " + e.title + " is not correct"; // this is optional
			  	} // end if email not correct
			} // end if email test
			
			else if (e.name.match(/Zip/g)) // check zip code
			{
				reg1 = /\d\d\d\d\d/;
				if( !reg1.test(e.value) )
					errors += "\n The " + e.title + " field should be 5 digits";
			}// end zip code
			
			else if (e.name.match(/OrgCode/g)) // check organization code
			{
				reg1 = /\d\d\d\d\d\d/; // 6 digits
				if( !reg1.test(e.value) )
					errors += "\n The " + e.title + " field should be 6 digits";
			}// end organization code

			else if (e.name.match(/Performance/g)) // check performance number
			{
				reg1 = /\d\d\d\d\d\d/; // 6 digits
				if( !reg1.test(e.value) )
					errors += "\n The " + e.title + " field should be 6 digits";
			}// end performance number 

			else if (e.name.match(/Sel/g)) // check any selection drop-down
			{
				if( e.value == -1 )
					errors += "\n Please select something from the " + e.title + " list ";
			}// end any selection list

			else if(e.name.match(/Phone/g))
			{
				reg1 = /\d\d\d-\d\d\d-\d\d\d\d/; // ###-###-####
				if( !reg1.test(e.value) )
					errors += "\n The " + e.title + " field is not a correct phone number";
			}// end if phone
			
			else if(e.name.match(/Date/g))
			{
				var DateOK = false;
				reg1 = /(\d{1,2})-(\d{1,2})-(\d{4})/;
				if(reg1.test(e.value))
				{
					var month = RegExp.$1 * 10 / 10; // why? because...
					var day = RegExp.$2;
					var year = RegExp.$3;
					switch(parseInt(month))
					{
						case 1: case 3: case 5: case 7: case 8: case 10: case 12:
						{
							if(day >= 1 && day <= 31)
								DateOK = true;
							break;
						}
						case 9: case 4: case 6: case 11: 
						{
							if(day >= 1 && day <= 30)
								DateOK = true;
							break;
						}
						case 2:
						{
							if(day >= 1 && day <= 28)
								DateOK = true;
							else if (day > 29)
								DateOK = false;
							else // day = 29 and month = 2; check for leap year
							{
								var yearNum = parseInt(year);
								// leap year = divisible by 4, except every 100 is out, 
								// except every 400 is in!
								if ( (yearNum % 4 == 0) && ((yearNum %100 != 0) || (yearNum %400 == 0) ))
									DateOK = true;
								else
									DateOK = false; 
							}
							break;
						}
						default: 
							DateOK = false;
					}// end switch
				} // end if regular expression passes
				if(DateOK == false)
					errors += "\n The " + e.title + " field is not a correct date (MM-DD-YYYY)";				
			} // end if date
		}//end if text field and not optional
	}//end for each element

	if(errors)
	{
		fullError = errors + "\n\n";
	}
	if(empty_fields)
	{
		fullError += "The following fields are empty:" + empty_fields;
	}
	if(errors || empty_fields)
	{
		alert(fullError);
		return false;
	}
	else
	{
		return true;
	}
}// end checkReqEntries


// AccessOK: returns true if job is allowed by user
// Input: UserTitles: string of the job titles for the current user, spearated by colons
//		AllowedTitles: string containing the job titles permitted to do this action, separated by colons
//		Page: string containing the page to go to if permitted
function AccessOK (UserTitles, AllowedTitles, Page )
{
	var UserTitleArray = UserTitles.split(":");
	var AllowedTitleArray = AllowedTitles.split(":");
	var i;
	var j;
	var found;
	var authorized;
	found = false;
	authorized = "";
	for(j = 0; j < AllowedTitleArray.length; j++){
		if(authorized == "") {
			authorized = AllowedTitleArray[j];
		}
		else{
			authorized += " or " + AllowedTitleArray[j];
		}
		for(i = 0; i < UserTitleArray.length; i++){
			if(UserTitleArray[i] == AllowedTitleArray[j]){
				location.href=Page;//alert("yes, the " + AllowedTitleArray[j] + " is allowed to do that");
				found = true;
			} //end if
		}//end for inner loop
	}//end for outer loop
	if (!found)
		alert ("Sorry, only the " + authorized + " is allowed to do that!");
} //end AccessOK