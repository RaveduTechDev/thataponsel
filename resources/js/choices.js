import Choices from "choices.js";

$(document).ready(function () {
    const choicesData = [];
    const placeholderText = $("#select-data").data("placeholder");
    $("#select-data option").each(function () {
        const value = $(this).attr("value");
        const label = $(this).text().trim();
        const description = $(this).data("description") || "";
        if (value) {
            choicesData.push({ value, label, description });
        }
    });

    $("#select-data").html("");

    const element = document.getElementById("select-data");
    const choices = new Choices(element, {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: placeholderText,
        fuseOptions: {
            keys: ["label", "description"],
            threshold: 0.3,
            ignoreLocation: true,
        },
    });

    choices.setChoices(choicesData, "value", "label", false);
});
