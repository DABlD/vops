function ss(title = "", text = ""){
	swal({
		type: "success",
		title: title,
		text: text,
		timer: 800,
		showConfirmButtom: false
	});
};

function se(title = "", text = ""){
	swal({
		type: "danger",
		title: title,
		text: text,
		timer: 800,
		showConfirmButtom: false
	});
};

function sc(title = "", text = ""){
	swal({
		type: "danger",
		title: title,
		text: text,
	});
};