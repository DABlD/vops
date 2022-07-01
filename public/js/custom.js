let errorColor = "#f76c6b";

function ss(title = "", text = ""){
	Swal.fire({
		icon: "success",
		title: title,
		text: text,
		timer: 800,
		showConfirmButtom: false
	});
};

function se(title = "", text = ""){
	Swal.fire({
		icon: "danger",
		title: title,
		text: text,
		timer: 800,
		showConfirmButtom: false
	});
};

function sc(title = "", text = ""){
	Swal.fire({
		icon: "danger",
		title: title,
		text: text,
	});
};