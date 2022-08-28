/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

function create_lesson(form_id) {
    document.getElementById(form_id).style.display = "block";
    document.getElementById("body").style.pointerEvents = "none";
    document.getElementById(form_id).style.pointerEvents = "auto";
}

function closeForm(form_id) {
    document.getElementById(form_id).style.display = "none";
    document.body.style.pointerEvents = "auto";
}
