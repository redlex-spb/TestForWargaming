document.forms[0].addEventListener('submit', function (e) {

	e.preventDefault();

	let formData = new FormData(this);

	let xhr = new XMLHttpRequest();
	xhr.open("POST", "");
	xhr.send(formData);
	xhr.responseType = "json";

	xhr.onload = function () {

		if ( document.getElementsByClassName('result').length < 1 ) {

			let div = document.createElement("div");
			div.classList.add('result');
			div.append( xhr.response.Message );

			stylizedDiv( xhr.response.Status, div );

			document.body.append(div);

		} else {

			document.getElementsByClassName('result')[0].innerText = xhr.response.Message;

			stylizedDiv( xhr.response.Status, document.getElementsByClassName('result')[0] );

		}

	};

	return false;

});

function stylizedDiv(status, div) {

	if ( status === "success" ) {

		div.style.cssText =
			"border: 3px solid green;\n" +
			"margin-top: 20px;\n" +
			"padding: 5px;";

	} else {

		div.style.cssText =
			"border: 3px solid red;\n" +
			"margin-top: 20px;\n" +
			"padding: 5px;";

	}

}