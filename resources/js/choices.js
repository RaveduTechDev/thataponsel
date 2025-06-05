import $ from "jquery";
import Choices from "choices.js";

$(document).ready(function () {
    let $subTotal = $("#sub-total");
    let $totalBayar = $("#total-bayar");
    let $qty = $("#qty");
    let currentPrice = 0;

    [$subTotal, $totalBayar].forEach(function ($element) {
        let rawValue = $element.val();
        let numberValue = parseFloat(rawValue) || 0;
        $element.val(formatRupiah(numberValue));
    });

    function formatRupiah(angka) {
        angka = parseFloat(angka) || 0;
        return (
            "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
    }

    $(".select-status").each(function () {
        const element = this;
        const checkSelected = $(element).data("check-selected");
        let initialSelected = $(element).find("option:selected").val();
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
                shouldSort: false,
            });
            element.choicesInstance = instance;

            if (
                (checkSelected === true || checkSelected === "true") &&
                initialSelected
            ) {
                instance.input.element.placeholder = "";
            } else {
                instance.input.element.placeholder =
                    "-- Pilih Status Penjualan --";
            }

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

                if (
                    (checkSelected === true || checkSelected === "true") &&
                    selectedValues.length > 0
                ) {
                    instance.input.element.placeholder = "";
                } else {
                    instance.input.element.placeholder =
                        "-- Pilih Status Penjualan --";
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

        let anySelected = false;

        // Ambil opsi dari HTML, cek ada selected gak
        $select.find("option").each(function () {
            const value = $(this).attr("value");
            const label = $(this).text().trim();
            const description = $(this).data("description") || "";
            const price = $(this).data("price") || 0;
            let isSelected = false;
            if (checkSelected) {
                isSelected = $(this).is(":selected");
                if (isSelected) anySelected = true;
            }
            choicesData.push({
                value: value,
                label: label,
                description: description,
                selected: isSelected,
                price: price,
            });
        });

        // Tambah opsi placeholder di depan yang bisa dipilih (disabled:false)
        choicesData.unshift({
            value: "",
            label: placeholderText,
            selected: !anySelected,
            disabled: false,
        });

        $select.html("");

        const element = $select[0];
        const choices = new Choices(element, {
            searchEnabled: true,
            removeItemButton: true, // tombol hapus pilihan aktif
            placeholder: true,
            placeholderValue: placeholderText,
            noResultsText: "Data tidak ditemukan",
            itemSelectText: "Tekan untuk memilih",
            fuseOptions: {
                keys: ["label", "description"],
                threshold: 0.3,
                ignoreLocation: true,
            },
            shouldSort: false,
        });

        choices.setChoices(choicesData, "value", "label", false);

        if (isCalculateSelect) {
            // Saat produk dipilih
            $(element).on("change", function () {
                let selectedValue = choices.getValue(true);

                // Jika kosong, artinya null
                if (selectedValue === "") {
                    selectedValue = null;
                }

                let price = 0;
                choicesData.forEach(function (item) {
                    if (item.value == selectedValue) {
                        price = item.price;
                    }
                });
                currentPrice = price; // simpan harga satuan

                let qtyVal = parseInt($qty.val()) || 1;
                let subTotal = currentPrice * qtyVal;

                $subTotal.val(formatRupiah(subTotal));
                calculateTotal(subTotal);
            });

            // Hitung ulang jika data-check-selected dan item sudah terpilih
            if (checkSelected) {
                let selectedItem = choicesData.find((item) => item.selected);
                if (selectedItem) {
                    currentPrice = selectedItem.price || 0;
                    let qtyVal = parseInt($qty.val()) || 1;
                    let subTotal = currentPrice * qtyVal;
                    $subTotal.val(formatRupiah(subTotal));
                    calculateTotal(subTotal);
                }
            }
        }
    });

    $qty.on("input", function () {
        let qtyVal = parseInt($(this).val()) || 1;
        if (qtyVal < 1) {
            qtyVal = 1;
            $(this).val(1);
        }
        let subTotal = currentPrice * qtyVal;
        $subTotal.val(formatRupiah(subTotal));
        calculateTotal(subTotal);
    });

    $("#diskon").on("input", function () {
        let discountVal = parseFloat($(this).val()) || 0;
        if (discountVal > 100) {
            $(this).val(100);
            discountVal = 100;
        }
        let priceString = $("#sub-total")
            .val()
            .replace(/[^0-9]/g, "");
        let price = parseFloat(priceString) || 0;
        calculateTotal(price);
    });

    function calculateTotal(price) {
        let discountPercent = parseFloat($("#diskon").val()) || 0;
        let discountAmount = Math.round((price * discountPercent) / 100);
        let total = price - discountAmount;
        $("#total-bayar").val(formatRupiah(total));
    }
});
