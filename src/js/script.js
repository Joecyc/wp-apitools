import "code-prettify";
window.addEventListener("load", function () {
  PR.prettyPrint();
  var typeField = document.querySelector("#type");
  var urlField = document.querySelector("#url");
  var idField = document.querySelector("#id");

  function removeRequiredAttribute() {
    idField.removeAttribute("required");
  }

  if (urlField) {
    urlField.addEventListener("keydown", function (event) {
      if (event.keyCode === 9 || event.keyCode === 13) {
        removeRequiredAttribute();
      }
    });
  }
  if (idField) {
    idField.addEventListener("click", function () {
      removeRequiredAttribute();
    });
  }
  if (urlField) {
    urlField.addEventListener("click", function () {
      removeRequiredAttribute();
    });
  }
  if (typeField) {
    typeField.addEventListener("click", function () {
      removeRequiredAttribute();
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var methodSelect = document.getElementById("method");
  var textareaLabel = document.getElementById("bodyLabel");
  var textareaRow = document.getElementById("body");

  if (methodSelect) {
    methodSelect.addEventListener("change", function () {
      var selectedValue = this.value;

      if (selectedValue === "post" || selectedValue === "patch") {
        textareaLabel.removeAttribute("hidden");
        textareaRow.removeAttribute("hidden");
      } else {
        textareaLabel.setAttribute("hidden", "true");
        textareaRow.setAttribute("hidden", "true");
      }
    });
  }
});
