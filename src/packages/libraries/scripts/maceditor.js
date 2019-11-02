<!--
// etCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav  = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_win   = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac    = (clientPC.indexOf("mac")!=-1);


// Helpline messages
z_help = "Абзац: <br><br>  (alt+z)";
b_help = "Жирный шрифт: <b>text</b>  (alt+b)";
i_help = "Наклонный шрифт: <i>text</i>  (alt+i)";
u_help = "Подчеркнутый шрифт: <u>text</u>  (alt+u)";
c_help = "E-mail: <a href='mailto:mail@mail.com'>my email</a> (alt+e)";
l_help = "Список: <ul>list</ul> (alt+l)";
o_help = "Нумерованный список: <ol> text </ol>  (alt+o)";
t_help = "Строка списка: <li> text  (alt+t)";
p_help = "Вставить ссылку на картинку : <img src=\"http://image_url\"></img>  (alt+p)";
w_help = "Вставить URL: <a href=\"\"></a> (alt+w)";
a_help = "Закрыть все открытые тэги";
s_help = "Цвет шрифта ";
f_help = "Размер шрифта";
q_help = "Шрифт";
g_help = "Строка списка: <li>item</li>";
f_help = "Файл из библиотеки (прикрепленный к записи):<pic>fileidentifier</pic>";
// Define the etCode tags
etcode= new Array();
imageTag=false;

ettags = new Array('<b>','</b>','<i>','</i>','<u>','</u>','<a href=','</a>','<img src=','</img>','<ul>','</ul>','<ol>','</ol>','','','','','','','','','<br><br>','','','','<li>','</li>');

imageTag_wtext = false;
etcode_wtext = new Array();

// Shows the help messages in the helpline window
function helpline(help,editfield) {
    eval ('var myhelpbox=document.editform.helpbox_'+editfield+';');
    myhelpbox.value = eval(help + "_help");
}


// Replacement for arrayname.length property
function getarraysize(thearray) {
    for (i = 0; i < thearray.length; i++) {
        if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
            return i;
        }
    return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
    thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
    thearraysize = getarraysize(thearray);
    retval = thearray[thearraysize - 1];
    delete thearray[thearraysize - 1];
    return retval;
}


function checkForm() {

    formErrors = false;

    if (document.editform.message.value.length < 2) {
        formErrors = "You must enter a message when posting";
    }

    if (formErrors) {
        alert(formErrors);
        return false;
    } else {
        etstyle(-1);
        //formObj.preview.disabled = true;
        //formObj.submit.disabled = true;
        return true;
    }
}

function emoticon(text) {
    text = ' ' + text + ' ';
    if (document.editform.message.createTextRange && document.editform.message.caretPos) {
        var caretPos = document.editform.message.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
        document.editform.message.focus();
    } else {
    document.editform.message.value  += text;
    document.editform.message.focus();
    }
}

function etfontstyle(etopen, etclose,editfield) {
    eval('var mytextarea=document.editform.'+editfield+';');
    eval('var myetcode=etcode_'+editfield+';');
    eval('var myimageTag=imageTag_'+editfield+';');
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (!theSelection) {
            mytextarea.value += etopen + etclose;
        mytextarea.focus();
            return;
        }
        document.selection.createRange().text = etopen + theSelection + etclose;
        mytextarea.focus();
        return;
    } else {
        mytextarea.value += etopen + etclose;
        mytextarea.focus();
        return;
    }
    storeCaret(mytextarea);
}


function simpletags(etnumber,editfield)
 {
  eval('var mytextarea=document.editform.'+editfield+';');
  var hreftext;
  var titletext;
  switch (etnumber)
    {
      case 8:
             hreftext = prompt("Введите e-mail","mailto:");
             titletext = prompt("Введите подпись","");           
            break;
      case 14:
             hreftext = prompt("Введите ссылку на рисунок","");
             titletext=prompt("Введите альтернативный текст","");
             break;
      case 16:
             hreftext = prompt("Введите ссылку","http://");
             titletext = prompt("Введите подпись","");           
            break;
      default:
              break;            
    
    }   
    if (hreftext!=null) {
        theSelection = document.selection.createRange().text; // Get text selection     
        if (etnumber!=14)   {
            if (theSelection)   {
                document.selection.createRange().text = ettags[6]+'"'+hreftext+'">'+titletext+ettags[7]+ theSelection;
            }   else    {
                mytextarea.value += ettags[6]+'"'+hreftext+'">'+titletext+ettags[7];    
            }   
         
        }    
        else
        {
            if (theSelection)   {
                document.selection.createRange().text =  ettags[8]+'"'+hreftext+'" alt="'+titletext+'">'+ettags[9]+theSelection;
            }   else    {
                mytextarea.value += ettags[8]+'"'+hreftext+'" alt="'+titletext+'">'+ettags[9];
            }
                     
        } 
    }   
 }
 
 function filetags(etnumber,editfield)
 {
  eval('var mytextarea=document.editform.'+editfield+';');
  idtext = prompt("Введите идентификатор файла","");  
  if (idtext!=null) {
    theSelection = document.selection.createRange().text; // Get text selection     
    if (theSelection)   {
        document.selection.createRange().text = '<pic>'+idtext+'</pic>'+theSelection;
    }   else    {
        mytextarea.value += '<pic>'+idtext+'</pic>'; 
    }   
  } 
 }
function etstyle(etnumber,editfield) {

    donotinsert = false;
    theSelection = false;
    etlast = 0;
    eval('var mytextarea=document.editform.'+editfield+';');
    eval('var myetcode=etcode_'+editfield+';');
    eval('var myimageTag=imageTag_'+editfield+';'); 
    if (etnumber == -1) { // Close all open tags & default button names
        while (myetcode[0]) {
            butnumber = arraypop(myetcode) - 1;         
            mytextarea.value += ettags[butnumber + 1];
            buttext = eval('document.editform.edittools' + butnumber + '_'+editfield+'.value');
            eval('document.editform.edittools' + butnumber + '_'+editfield+'.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
        }
        myimageTag = false; // All tags are closed including image tags :D
        mytextarea.focus();
        return;
    }

    if ((clientVer >= 4) && is_ie && is_win)
        theSelection = document.selection.createRange().text; // Get text selection

    if (theSelection) {
        // Add tags around selection
        document.selection.createRange().text = ettags[etnumber] + theSelection + ettags[etnumber+1];
        mytextarea.focus();
        theSelection = '';
        return;
    }

    // Find last occurance of an open tag the same as the one just clicked
    for (i = 0; i < myetcode.length; i++) {
        if (myetcode[i] == etnumber+1) {
            etlast = i;
            donotinsert = true;
        }
    }

    if (donotinsert) {      // Close all open tags up to the one just clicked & default button names
        while (myetcode[etlast]) {
                butnumber = arraypop(myetcode) - 1;
                mytextarea.value += ettags[butnumber + 1];
                buttext = eval('document.editform.edittools' + butnumber +'_' + editfield + '.value');
                eval('document.editform.edittools' + butnumber + '_'+ editfield + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
                myimageTag = false;
            }
            mytextarea.focus();
            return;
    } else { // Open tags

        if (myimageTag && (etnumber != 14)) {       // Close image tag before adding another
           mytextarea.value += ettags[15];
            lastValue = arraypop(myetcode) - 1; // Remove the close image tag from the list
            eval('document.editform.edittools14_'+editfield+'.value = "Img";');  // Return button back to normal state
            myimageTag = false;
        }
    
        // Open tag
        mytextarea.value += ettags[etnumber];
        if ((etnumber == 14) && (myimageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
        if (etnumber!=22)
        {
            arraypush(myetcode,etnumber+1);
            eval('document.editform.edittools'+etnumber+'_'+editfield+'.value += "*"');
        }   
        mytextarea.focus();
        return;
    }
    storeCaret(mytextarea);
}


function storeCaret(textEl) {
    if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}




function preview_html(textEl, css_path_array){
   eval("inner_text = document.editform."+textEl+".value;");
   
    css_string = "";
    if(css_path_array.length > 1){
      for(i=0; i < css_path_array.length; i++){
         css_string += "<link  rel='stylesheet' type='text/css' href='"+css_path_array[i]+"'/>";
      }

    
    }

    vmrl = window.open('','fileview','location=0,menubar=0,resizable=yes,status=0,menubar=no,width=553,height=600,scrollbars=yes');
    vmrl.document.write('<html><head><title>Preview</title>'+css_string+'</head><body bgcolor="#ffffff" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">');
    vmrl.document.write('<table border="0" cellpadding="15" cellspacing="7" width="100%" height="100%" align="center" bgcolor="#CECECE"><tr><td bgcolor="#FFFFFF" valign="top" align="left">');
    vmrl.document.write('<a href="javascript: window.close()" title="Click to close">Close</a><hr/>'+inner_text);
    vmrl.document.write('</td></tr></table>');
    vmrl.document.write('</body></html>');
    vmrl.focus();
   
   //alert(inner_text);


}

