
function AJAXModifyInner (url, elementOld, elementNew)
{
	var request;
	var text;
	
	request = new AJAXRequest ();
	request.Finished = function (status,
								 statusText,
								 responseText,
								 responseXML)
	{
		if (status == 200)
		{
			text = responseText;
		}
		else
		{
			text = "Error " + status + ": '" + statusText + "'";
		}
		document.getElementById (elementNew).innerHTML = text;
	}
	request.Get (url)
}

function AJAXExecute (url)
{
	var request;
	var text;
	
	request = new AJAXRequest ();
	request.Get (url);
}

function HideAndShow (elementOld, elementNew)
{
	document.getElementById (elementNew).style.visibility = 'visible';
	document.getElementById (elementOld).innerHTML = '';
	document.getElementById ($elementOld).style.visibility = 'hidden';
}