function pressed(type,object)
{
	if(navigator.userAgent.indexOf('MSIE') != -1)
	{
		if(object.keyCode > 0)
		{
		switch(type)
		{
			case 'N' : if (object.keyCode < 45 || object.keyCode > 57) object.returnValue = false; break;
			case 'ON' : if (object.keyCode < 48 || object.keyCode > 57) object.returnValue = false; break;
			case 'none' : object.returnValue = false;break;
			default : if(object.keyCode == 34 || object.keyCode == 92) object.returnValue = false;
		}
		}
	}
	else 
	{
		if(object.charCode > 0)
		{
		switch(type)
		{
			case 'N' : if (object.charCode < 45 || object.charCode > 57) object.preventDefault(); break;
			case 'ON' : if (object.charCode < 48 || object.charCode > 57) object.preventDefault(); break;
			case 'none' : object.preventDefault();break;
			default : if(object.charCode == 34 || object.charCode == 92) object.preventDefault();
		}
		}
	}
}

function commaSplit(srcNumber)
{
	while (srcNumber.indexOf(',') != -1) srcNumber = srcNumber.replace(',','');
	var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');
	var arrNumber = srcNumber.split('.');
	arrNumber[0] += '.';
	do {
		arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2');
	} while (rxSplit.test(arrNumber[0]));
	if (arrNumber.length > 1) return arrNumber.join('');
	else return arrNumber[0].split('.')[0];
}

function commaSplitID(srcNumber)
{
	while (srcNumber.indexOf('.') != -1) srcNumber = srcNumber.replace('.','');
	var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');
	var arrNumber = srcNumber.split(',');
	arrNumber[0] += ',';
	do {
		arrNumber[0] = arrNumber[0].replace(rxSplit, '$1.$2');
	} while (rxSplit.test(arrNumber[0]));
	if (arrNumber.length > 1) return arrNumber.join('');
	else return arrNumber[0].split(',')[0];
}

function format_npwp(value)
{
	while (value.indexOf('.') != -1) value = value.replace('.','');
	while (value.indexOf('-') != -1) value = value.replace('-','');
	var arr_mark = Array();
	var simpan = '';
	arr_mark[2] = ".";
	arr_mark[5] = ".";
	arr_mark[8] = ".";
	arr_mark[9] = "-";
	arr_mark[12] = ".";
	var length = value.length;
	for(i=0;i<length;i++)
	{
		no = i + 1;
		simpan += value.substr(i,1);
		if(arr_mark[no] && length > no) simpan += arr_mark[no];
	}
	return simpan;
}