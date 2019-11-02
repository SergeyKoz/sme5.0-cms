    // File list routines
function fileWindow(filestorage,file)  {
    if(file.substr(0,1)=="/"){
       file = file.substr(1,file.length);
    }
    if (file.length!=0) {
        vmrl = window.open('','fileview','location=0,menubar=0,resizable=yes,status=0,menubar=no,width=400,height=500,scrollbars=no');
        vmrl.document.open();
        vmrl.document.write('<html><head><title></title></head><body bgcolor="#ffffff" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">');
        vmrl.document.write('<table border="0" cellpadding="15" cellspacing="7" width="100%" height="100%" align="center" bgcolor="#CECECE"><tr><td bgcolor="#FFFFFF" valign="middle" align="center">');
        vmrl.document.write('<a href="javascript: window.close()" title="Click to close"><img src="'+filestorage+file+'" border=0></a>');
        vmrl.document.write('</td></tr></table>');
        vmrl.document.write('</body></html>');
        vmrl.document.close();
        vmrl.focus();
    }
}
    // File list routines
    function doChangeAll(form, destination_name, state) {
        for (var i = 0; i < form.elements.length; i++) {
            var e = form.elements[i];
            if (e.name == destination_name && e.type == 'checkbox')
                e.checked = state;
        }
    }

    function doSelectAll(form, source_name, destination_name) {
        doChangeAll(form, destination_name, form.elements[source_name].checked);
    }

    function syncSelected(form, element) {
        var checkAll = form.elements['check_all'];
        if (element.checked) {
            var allChecked = true;
            for (var i = 0; i < form.elements.length; i++) {
                var e = form.elements[i];
                if (e.name != 'check_all' && e.type == 'checkbox' && !e.checked) {
                    allChecked = false;
                    break;
                }
            }
            checkAll.checked = allChecked;
        }
        else {
            if (checkAll.checked)
                checkAll.checked = false;
        }
    }

    function doDeleteSingleFile(form, element) {
        if (confirm('Are you sure ?')) {
            doChangeAll(form, false);
            element.checked = true;
            form.elements['event'].value = 'DeleteFiles';
            form.submit();
        }
    }

    function checkSelected(form, event, message) {
        for (var i = 0; i < form.elements.length; i++) {
            var e = form.elements[i];
            if (e.name != 'check_all' && e.type == 'checkbox' && e.checked) {
                if (confirm('Are you sure ?')) {
                form.elements['event'].value = event;
                form.submit();
                return;
                }
                else {
                return;
                }
            }
        }
        alert(message);
    }

   // Confirm functionality
   function DoDelete(formName) {
        if (confirm('Are you sure ?')) {
            document.forms[formName].elements['event'].value = 'delete';
            document.forms[formName].submit();
        }
    }
    function DoNoFormDelete(target) {
        if (confirm('Are you sure ?')) {
            document.location.href = target;
        }
    }

    function deleteFile() {
        var selectedIndex = document.hiddenForm.fileList.selectedIndex;
        if (selectedIndex != -1) {
            if(confirm('Are you sure?')){
                document.hiddenForm.event.value = "deleteFile";
                document.hiddenForm.submit();
            }
        } else {
           alert('No file selected');
        }

    }


    function ChkPsw(f) {
        if((f.userPassword.value==f.userPassword1.value) && (f.userPassword.value!='')) return true;
        else {
            alert('Fields \'Password\' and \'Confirm password\' should coincide');
            return false;
        }
    }

    function printwin(url_win){
        print_window=window.open(url_win,'win2','menubar=yes,width=600,height=600,scrollbars=yes');
        return false;
    }

    function pr(){
        a=1
        print();
    }


       // File list dialog routines
    function FilesDlg(form, element,directory, tag_id) {
        tag_id = parseInt("0"+tag_id)*1;
        window.open('?page=filestoragedlg&isOpen=1&form=' + form + '&element=' + element + '&directory=' + directory + '&tag_id=' + tag_id,
            'FilesDlg', 'menubar=no,width=400,height=400,scrollbars=yes,resizable=no');
    }
    function FilesDlg2(form, element,directory, tag_id) {
        tag_id = parseInt("0"+tag_id)*1;
        window.open('?page=filedlg&form=' + form + '&element=' + element + '&directory=' + directory + '&tag_id=' + tag_id,
            'FilesDlg2', 'menubar=no,width=600,height=500,scrollbars=yes,resizable=yes');
    }

    // File list dialog routines
    function UploadDlg(directory, element, form, tag_id) {
        tag_id = parseInt("0"+tag_id)*1;
        document.location.href='?page=uploaddlg&directory=' + directory+"&form="+form+"&element="+element+ '&tag_id=' + tag_id;//,
            //'UploadDlg', 'height=105,width=325,status=no,toolbar=no,menubar=no,location=no,resizable=yes';
    }
    // File list dialog routines
    function CancelUploadDlg(directory, element, form, tag_id) {
        tag_id = parseInt("0"+tag_id)*1;
        document.location.href='?page=filestoragedlg&directory=' + directory+"&form="+form+"&element="+element+ '&tag_id=' + tag_id;//,
            //'UploadDlg', 'height=105,width=325,status=no,toolbar=no,menubar=no,location=no,resizable=yes';
    }


    function cb_SaveFilePath(form, element, value, tag_id) {
     tag_id = parseInt("0"+tag_id)*1;
     switch (tag_id)
        {
          case 1:
                if(document.selection.createRange){
                    theSelection = document.selection.createRange().text; // Get text selection
                } else {
                    theSelection = false;
                }

                if (theSelection)   {
                    document.selection.createRange().text =  '<img src="'+value+'">';
                }   else    {
                    document.forms[form].elements[element].value += '<img src="'+value+'">';
                }


               break;

          default:
                 document.forms[form].elements[element].value = value;
               break;

        }


    }


    function cb_LoadContent(form, element, value) {
      return document.forms[form].elements[element].value;
    }

    function cb_SaveContent(form, element,value) {
                 document.forms[form].elements[element].value = value;
    }

    function ClearField(form, element) {
     document.forms[form].elements[element].value ="";
    }

    function clearAll (name) {
		var srcItems = document.getElementById(name);
		var itemList = srcItems.rows;
		for (i=1;i<itemList.length;i++){
			if(itemList[i].name == "selected") {
				itemList[i].style.backgroundColor = (i % 2==0?"E9D7B3":"E8CD98");
			} else {

				if(itemList[i].name == "warning") {
					itemList[i].style.backgroundColor = (i % 2==0?"E9B3B3":"E89898");
				} else {
					itemList[i].style.backgroundColor = (i % 2==0?"ffffff":"eeeeee");
				}

			}
		}
    }

    function GoBack(){
        document.editform.event.value="GoBack";
        document.editform.submit();
        return false;
    }

    function Apply(){
        document.editform.event.value="DoApplyItem";
        document.editform.submit();
        return false;
    }

    function Save(){
    	document.editform.submit();
    	return false;
    }

    function FilesDlg_View(appPath) {
                var selectedIndex = document.hiddenForm.fileList.selectedIndex;
                if (selectedIndex != -1) {
                    window.open(appPath + document.hiddenForm.fileList.options[selectedIndex].value,
                        'Viewer', '');
                }
    }

    function FilesDlg_Cancel() {
                window.close();
    }

    function changeFolder(newFolder) {
                document.hiddenForm.elements['directory'].value = newFolder;
                document.hiddenForm.submit();
    }

    function FilesDlg_Go() {
                var selectedIndex = document.hiddenForm.newDirectory.selectedIndex;
                if (selectedIndex != -1) {
                    changeFolder(document.hiddenForm.newDirectory.options[selectedIndex].value);
                }
    }

    function createFolder() {
                document.hiddenForm.event.value = "create";
                document.hiddenForm.submit();
    }

    function FilesDlg_Create() {
              createFolder();
    }


    function FilePreview(fieldname,filestorage) {
       str='tmp=document.editform.'+fieldname+'.value;';
       eval(str);
         if (tmp.length!=0) window.open(filestorage+tmp,'win2','menubar=no,width=400,height=400,scrollbars=yes');
    }

    function submitForm(event)  {
        document.editform.event.value=event;
      document.editform.submit();
    }

  function submitListForm(event,formname)  {
      eval('document.'+formname+'.event.value="'+event+'"');
      eval('document.'+formname+'.submit();');
    }
    function rollOver(im) {
        i = eval(im + "_" + ".src");
        document.images[im].src = i + act + ext;
    }

    function rollOut(im) {
        i = eval(im + "_" + ".src");
        document.images[im].src = i + ext;
    }


    function writePrice(d,c,size) {
        dLen = d.length;
        cLen = c.length;
    CimStart = '<img src="'+ipath+'price/c_';
     size?imStart='<img src="'+ipath+'price/':imStart=CimStart;
       imEnd = '.gif" align=absmiddle>';
         div = imStart + "dot" + imEnd;
      dollar = imStart + "dollar" + imEnd;
        doll = "";
        cent = "";
        for(x=0; x<dLen; x++) { doll += (imStart + d.charAt(x) + imEnd);  }
        for(x=0; x<cLen; x++) { cent += (CimStart + c.charAt(x) + imEnd); }
        document.write(doll + div + cent + dollar);
    }


    function go2()
    {
        box = document.forms["regions"].regionid;
        vall = "";
    destination = box.options[box.selectedIndex].text;


for(a=0;a<destination.length;a++) {
        cha = destination.charAt(a);
        if(cha=="[" || cha=="-" || cha=="]") {}
        else {
        vall += cha;
        }
    }

    if (destination) {
            lowercaseValue = destination;
            ch = lowercaseValue.substring(0,1);
            rest = lowercaseValue.substring(1);
            up = ch.toLowerCase();
            uppercaseValue = up + rest;
            document.images["countryFlag"].src = ipath + "flags/" + uppercaseValue + ".gif";
            document.forms["regions"].countryName.value = vall.toUpperCase();
        }
    }


    var minItems = 1;
    var maxItems = 999;

    function decrease(item) {
                curr = document.all[item].value;
        if(curr<minItems || curr > maxItems) { curr = 1; }
                curr!=minItems?curr--:curr = curr;
        document.all[item].value = curr;
    }

    function increase(item) {
        curr = document.all[item].value;
                if(curr<minItems || curr > maxItems) { curr = 1; }
        curr!=maxItems?curr++:curr = curr;
        document.all[item].value = curr;
    }


        function add2cart(link,item,form) {
            if(!form) { form = "productdetails" }
            uu = link + "&quantity=" + document.forms[form][item].value;
            window.location.href = uu;
        }


function resizeImm() {
izosepx = 0;
izosepx2 = 0;
for(isize=0;isize<(tree2.Nodes.length);isize++) {
ccc = "tabbl2_" + isize;
ccc2 = "tabbl_" + isize;
if(document.all[ccc] && document.all[ccc]) {
izosepx += document.all[ccc].scrollHeight;
izosepx2 += document.all[ccc2].scrollHeight;
}
}
 return izosepx+izosepx2;
}

// Print this page
function printit() {
    if (window.print) window.print();
}

var scroll_subjects = new Array();

function AddScroll(offset_holder_name, scroll_name ){
  //scroll_subjects[scroll_subjects.length] = new Array(scroll_name, offset_holder_name);
}

function ScrollHeader()  {
   for(i=0; i<scroll_subjects.length; i++) {
      //alert(scroll_subjects[i][0] + " " +scroll_subjects[i][1]);
      if ((document.body.scrollTop > scroll_subjects[i][2]) && (document.body.scrollTop < scroll_subjects[i][3])) {
          document.all[scroll_subjects[i][0]].style.top = document.body.scrollTop-scroll_subjects[i][2];
      } else {
          document.all[scroll_subjects[i][0]].style.top = 0;
      }
      //alert(document.all[scroll_subjects[i][0]].style.display);// = "block";
   }
}


//var a = "";
function GetRecursiveOffset(object, offset){
    if(object.parentNode){
         if((object.nodeName != "FORM") && (object.nodeName != "TR") && (object.nodeName != "THEAD") && (object.nodeName != "TBODY")){
             //a += object.nodeName+" -> "+object.offsetTop+"\n";
             //offset += object.offsetTop
         }
         return GetRecursiveOffset(object.parentNode, offset);
    } else return offset;
}


function InitScroll(){
    if(scroll_subjects.length > 0){
        for(i=0; i<scroll_subjects.length; i++){
            scroll_subjects[i][2] = GetRecursiveOffset(document.all[scroll_subjects[i][1]], 0);
            scroll_subjects[i][3] = scroll_subjects[i][2] +
                                    document.all[scroll_subjects[i][1]].parentNode.clientHeight -
                                    document.all[scroll_subjects[i][0]].clientHeight - 32;
        }
        window.onscroll=ScrollHeader;
    }
}
