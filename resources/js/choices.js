import Choices from "choices.js";

$(document).ready(function () {
    // Fungsi untuk memformat angka ke Rupiah
    function formatRupiah(angka) {
        angka = parseFloat(angka) || 0;
        return (
            "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
    }

    $(".select-status").each(function () {
        const element = this;

        // Ambil nilai awal dari data attribute "selected"
        let initialSelected = $(element).data("selected");
        let initialClass =
            initialSelected === "selesai"
                ? "item__success"
                : initialSelected === "proses"
                ? "item__warning"
                : "item__danger";

        if (!element.choicesInstance) {
            const instance = new Choices(element, {
                editItems: true,
                maxItemCount: 1,
                maxItemText: "Hanya boleh memilih satu status",
                placeholder: true,
                placeholderValue: "-- Pilih Status Penjualan --",
                removeItemButton: true,
                classNames: {
                    item: ["choices__item", initialClass],
                },
            });
            element.choicesInstance = instance;

            element.addEventListener("change", function () {
                const selectedValues = instance.getValue(true);
                const selectedValue = selectedValues[0];
                const newClass =
                    selectedValue === "selesai"
                        ? "item__success"
                        : selectedValue === "proses"
                        ? "item__warning"
                        : "item__danger";

                const itemElement =
                    instance.containerInner.element.querySelector(
                        ".choices__item"
                    );
                if (itemElement) {
                    itemElement.classList.remove(
                        "item__success",
                        "item__warning",
                        "item__danger"
                    );
                    itemElement.classList.add(newClass);
                }

                if (selectedValues.length > 0) {
                    instance.input.element.placeholder = "";
                } else {
                    instance.input.element.placeholder =
                        "--Pilih Status Penjualan--";
                }
            });
        } else if (typeof Choices !== "undefined") {
            element.choicesInstance.setChoices(
                newChoices,
                "value",
                "label",
                false
            );
        }
    });

    $(".select-data").each(function () {
        const choicesData = [];
        const $select = $(this);
        const placeholderText = $select.data("placeholder");
        const checkSelected = $select.attr("data-check-selected") === "true";
        const isCalculateSelect =
            $select.data("calc") === true || $select.data("calc") === "true";

        $select.find("option").each(function () {
            const value = $(this).attr("value");
            if (value !== "") {
                const label = $(this).text().trim();
                const description = $(this).data("description") || "";
                const price = $(this).data("price") || 0;
                let isSelected = false;
                if (checkSelected) {
                    isSelected = $(this).is(":selected");
                }
                choicesData.push({
                    value: value,
                    label: label,
                    description: description,
                    selected: isSelected,
                    price: price,
                });
            }
        });

        $select.html("");

        const element = $select[0];
        const choices = new Choices(element, {
            searchEnabled: true,
            removeItemButton: true,
            placeholder: true,
            placeholderValue: placeholderText,
            noResultsText: "Data tidak ditemukan",
            itemSelectText: "Tekan untuk memilih",
            fuseOptions: {
                keys: ["label", "description"],
                threshold: 0.3,
                ignoreLocation: true,
            },
        });

        choices.setChoices(choicesData, "value", "label", false);

        if (isCalculateSelect) {
            $(element).on("change", function () {
                var selectedValue = choices.getValue(true);
                var price = 0;
                choicesData.forEach(function (item) {
                    if (item.value == selectedValue) {
                        price = item.price;
                    }
                });
                $("#sub-total").val(formatRupiah(price));
                calculateTotal(price);
            });
        }
    });

    $("#diskon").on("input", function () {
        var discountVal = parseFloat($(this).val()) || 0;
        if (discountVal > 100) {
            $(this).val(100);
            discountVal = 100;
        }
        var priceString = $("#sub-total")
            .val()
            .replace(/[^0-9]/g, "");
        var price = parseFloat(priceString) || 0;
        calculateTotal(price);
    });

    function calculateTotal(price) {
        var discountPercent = parseFloat($("#diskon").val()) || 0;
        var discountAmount = Math.round((price * discountPercent) / 100);
        var total = price - discountAmount;
        $("#total-bayar").val(formatRupiah(total));
    }
});
