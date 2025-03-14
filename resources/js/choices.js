import Choices from "choices.js";

$(document).ready(function () {
    const choicesData = [];
    const $select = $("#select-data");
    const placeholderText = $select.data("placeholder");
    // Cek apakah select memiliki attribute data-check-selected="true"
    const checkSelected = $select.attr("data-check-selected") === "true";

    // Iterasi setiap <option> di dalam select
    $select.find("option").each(function () {
        const value = $(this).attr("value");
        // Lewati placeholder (value kosong)
        if (value !== "") {
            const label = $(this).text().trim();
            const description = $(this).data("description") || "";
            // Jika checkSelected aktif, gunakan nilai native :selected
            let isSelected = false;
            if (checkSelected) {
                isSelected = $(this).is(":selected");
            }
            choicesData.push({
                value: value,
                label: label,
                description: description,
                selected: isSelected,
            });
        }
    });

    // Hapus isi select sehingga Choices.js akan menggunakan data dari choicesData
    $select.html("");

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

    // Set data ke Choices.js. Argumen keempat false agar data tidak diurut ulang secara otomatis.
    choices.setChoices(choicesData, "value", "label", false);
});
