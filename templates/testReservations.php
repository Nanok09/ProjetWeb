<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=testReservations");
    die("");
}

include_once "libs/libSecurisation.php"; // pour securiser

securiser("?view=accueil"); //vérifie si l'utilisateur est connecté et le renvoie à l'accueil sinon
$id_user = valider("id_user", "SESSION");

?>

<div class="container">
    <div id="calendar"></div>
    <h2>Ajouter créneau dispo</h2>
    <form id="add_creneau">
        date
        <input type="date" name="date" required>
        debut
        <input type="time" name="time_start" step="1800" required>
        fin
        <input type="time" name="time_end" step="1800" required>
        capacite
        <input type="number" name="capacite" required>
        <input type="submit">
    </form>
    <h2>Ajouter réservation</h2>
    <form id="add_reservation">
        date
        <input type="date" name="date" required>
        debut
        <input type="time" name="time_start" step="1800" required>
        fin
        <input type="time" name="time_end" step="1800" required>
        capacite
        <input type="number" name="nb_personnes" required>
        <input type="submit">
    </form>
</div>
<script>
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    initialView: 'timeGridWeek',
    customButtons: {
        refreshButton: {
            text: 'Actualiser',
            click: function() {
                console.log('clicked the custom button!');
                calendar.refetchEvents();
            }
        }
    },
    headerToolbar: {
        left: 'title',
        right: 'refreshButton today prev,next'
    },
    height: 500,
    locale: "fr",
    allDaySlot: false,
    events: function(info, successCallback, failureCallback) {
        $.post({
            type: "POST",
            url: "libs/api.php",
            data: {
                action: "get_creneaux_place",
                id_place: 1,
                start: info.startStr,
                end: info.endStr
            },
            dataType: "json",
            error: function(err) {
                failureCallback(err);
            },
            success: function(res) {
                successCallback(res.data);
            }
        });
    }
});
calendar.render();

function formToJson(form) {
    var serializedArray = $(form).serializeArray();
    var json = {};
    for (var i = 0; i < serializedArray.length; i++) {
        json[serializedArray[i].name] = serializedArray[i].value;
    }
    return json;
}
$("form#add_creneau").submit(function(event) {
    console.log('form add creneau');
    var data = formToJson(this);
    data.action = "add_creneau_dispo";
    data.id_place = 1;
    if (data.time_end === "00:00") {
        data.time_end = "23:59";
    }
    $.post('libs/api.php', data, function(res) {
        console.log(res);
        calendar.refetchEvents();
    }, "json")
    event.preventDefault();
});
$("form#add_reservation").submit(function(event) {
    console.log('form reservation');
    var data = formToJson(this);
    data.action = "add_reservation";
    data.id_place = 1;
    if (data.time_end === "00:00") {
        data.time_end = "23:59";
    }
    $.post('libs/api.php', data, function(res) {
        console.log(res);
        if (!res.success) {
            alert('pas possible');
        }
        calendar.refetchEvents();
    }, "json")
    event.preventDefault();
});
</script>
