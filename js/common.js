function ajouterAlert(container, alertClass, message) {
  container.empty();
  container.append(
    $("<div>").addClass("alert").addClass(alertClass).text(message)
  );
}
