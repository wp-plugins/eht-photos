
var AJAXRequest = function ()
{
	this.request = null;
	if (window.XMLHttpRequest)
	{
		this.request = new XMLHttpRequest ();
	}
	else if (window.ActiveXObject)
	{
		var versions = new Array ("Msxml2.XMLHTTP.5.0",
								  "Msxml2.XMLHTTP.4.0",
								  "Msxml2.XMLHTTP.3.0",
								  "Msxml2.XMLHTTP",
								  "Microsoft.XMLHTTP");
		var goOn = true;
		for (var i = 0; (i < versions.length) && goOn; i++)
		{
			try
			{
				this.request = new ActiveXObject (versions[i]);
				goOn = false;
			}
			catch (error)
			{
			}
		}
	}
}

AJAXRequest.prototype.Get = function (url)
{
	var ok;
	var thisObject;
	
	ok = false;
	if (this.request)
	{
		thisObject = this;
		this.request.open ("GET", url, true);
		this.request.onreadystatechange = function ()
		{
			switch (thisObject.request.readyState)
			{
				case 1:
					thisObject.Loading ();
					break;
				case 2:
					thisObject.Loaded ();
					break;
				case 3:
					thisObject.Interacting ();
					break;
				case 4:
					thisObject.Finished (thisObject.request.status,
										 thisObject.request.statusText,
										 thisObject.request.responseText,
										 thisObject.request.responseXML);
					break;
			}
		}
		this.request.send (null);
		ok = true;
	}
	
	return (ok);
}

AJAXRequest.prototype.Loading = function ()
{
}

AJAXRequest.prototype.Loaded = function ()
{
}

AJAXRequest.prototype.Interacting = function ()
{
}

AJAXRequest.prototype.Finished = function (status,
										   statusText,
										   responseText,
										   responseXML)
{
}
