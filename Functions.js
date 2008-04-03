
function AJAXModifyInner (url, element)
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
		document.getElementById (element).innerHTML = text;
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
