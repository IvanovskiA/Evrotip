// Jquery table script
$(document).ready(function () {
  $("table").DataTable({
    rowReorder: {
      selector: 'td:nth-child(2)'
    },
    responsive: true,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "language": {
      "zeroRecords": "Ne e pronajden nieden dobitnik!"
    },
    paging: true,
    dom: 'lBfrtip',
    buttons: [
      'copy', 'excel', 'pdf'
    ]
  });
});

//Scroll Back To Top Button
//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// $(function () {
//   $('select option').each(function () {
//     $(this).sibilings("[value=" + this.value + "]").remove();
//   });
// });

var optionValues = [];
$('select option').each(function () {
  if ($.inArray(this.value, optionValues) > -1) {
    $(this).remove()
  } else {
    optionValues.push(this.value);
  }
})

// Alert message indexAdmin
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function () {
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function () { div.style.display = "none"; }, 600);
  }
}

// navLinks style and refresh page on resize
$("document").ready(function () {
  $(".navLink").css("font-weight", "bold");
  // $(".searchresult").show(1000);
});
$(window).resize(function () { location.reload(); });

// Upload folder 
$(".browse-button").on("click", () => {
  $("#file").click();
})

$("#file").on("change", ({ target }) => {
  const formData = new FormData();

  const files = target.files;

  const file_name = "file[]";
  const folder_name = "folder[]";

  for (let i = 0; i < files.length; i++) {
    const file = files[i];

    if (file.name !== "") {
      formData.append(file_name, file);
      formData.append(folder_name, file.webkitRelativePath);
    }
  }

  const xml = new XMLHttpRequest();

  xml.onreadystatechange = () => {
    if (xml.readyState == XMLHttpRequest.DONE) {
      console.log(xml.responseText);
    }
  }

  xml.upload.onprogress = ({ loaded, total }) => {
    let progress = ((loaded / total) * 100).toFixed(0) + "%";

    $(".progress-bar").html(progress);
    $(".progress-bar").css("width", progress);
    // console.log(progress);
    if (progress === "100%") {
      setTimeout(function () {
        location.reload(true);
      }, 1000);
    }
  }

  xml.open("POST", "folders.php", true);
  xml.send(formData);
});