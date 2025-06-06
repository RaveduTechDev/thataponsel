import $ from "jquery";
import Choices from "choices.js";

$(document).ready(function () {
    const $garansiCheckbox = $("#garansi-checkbox");
    const $keteranganInput = $("#keterangan");
    const $qty = $("#qty");
    const $subTotalInput = $("#sub-total");
    const $diskonInput = $("#diskon");
    const $totalBayarInput = $("#total-bayar");

    let currentPrice = 0;
    let isManualOverride = false;
    let manualUnitPrice = 0;

    function formatRupiah(angka) {
        angka = parseFloat(angka) || 0;
        return (
            "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
    }

    [$subTotalInput, $totalBayarInput].forEach(($input) => {
        if ($input.length) {
            const cleanValue = $input.val().replace(/[^0-9]/g, "");
            const formattedValue = formatRupiah(parseFloat(cleanValue) || 0);
            $input.val(formattedValue);
        }
    });

    function calculateTotal(subtotalAngka) {
        let discountPercent = parseFloat($diskonInput.val()) || 0;
        if (discountPercent < 0) discountPercent = 0;
        if (discountPercent > 100) discountPercent = 100;
        let discountAmount = Math.round(
            (subtotalAngka * discountPercent) / 100
        );
        let total = subtotalAngka - discountAmount;
        $totalBayarInput.val(formatRupiah(total));
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
        const $select = $(this);
        const placeholderText = $select.data("placeholder") || "";
        const checkSelected = $select.attr("data-check-selected") === "true";
        const isCalculateSelect =
            $select.data("calc") === true || $select.data("calc") === "true";

        const initStockId = $select.data("penjualan-stock-id") || null;
        const initKeterangan = $select.data("penjualan-keterangan") || "";
        const initGaransi = $select.data("penjualan-garansi") || "";

        let anySelected = false;
        const choicesData = [];

        $select.find("option").each(function () {
            const $opt = $(this);
            const value = $opt.val();
            const label = $opt.text().trim();
            const price = $opt.data("price") || 0;
            const garansi = $opt.data("garansi") || "";
            const keterangan = $opt.data("keterangan") || "";
            const isSelected = checkSelected && $opt.is(":selected");

            if (isSelected) anySelected = true;

            choicesData.push({
                value: value,
                label: label,
                price: price,
                garansi: garansi,
                keterangan: keterangan,
                selected: isSelected,
                disabled: false,
            });
        });

        choicesData.unshift({
            value: "",
            label: placeholderText || "-- Pilih --",
            price: 0,
            garansi: "",
            keterangan: "",
            selected: !anySelected,
            disabled: false,
        });

        $select.html("");
        const selectEl = $select[0];
        const choices = new Choices(selectEl, {
            searchEnabled: true,
            removeItemButton: false,
            placeholder: true,
            placeholderValue: placeholderText || "-- Pilih --",
            noResultsText: "Data tidak ditemukan",
            itemSelectText: "Tekan untuk memilih",
            shouldSort: false,
        });
        choices.setChoices(choicesData, "value", "label", false);

        if (isCalculateSelect) {
            if ($subTotalInput.length && $qty.length) {
                let cleanSub = $subTotalInput.val().replace(/[^0-9]/g, "");
                let initSub = parseFloat(cleanSub) || 0;
                let initQty = parseInt($qty.val()) || 1;
                if (initSub > 0 && initQty > 0) {
                    isManualOverride = true;
                    manualUnitPrice = initSub / initQty;
                    currentPrice = manualUnitPrice;
                }
            }

            if (initKeterangan !== "") {
                $keteranganInput.val(initKeterangan).prop("disabled", false);
            }
            if (initGaransi === "ya") {
                $garansiCheckbox.prop("checked", true).prop("disabled", false);
            } else {
                $garansiCheckbox.prop("checked", false).prop("disabled", false);
            }

            $(selectEl).on("change", function () {
                let selectedValue = choices.getValue(true);
                if (selectedValue === "") selectedValue = null;

                const selectedObj =
                    choicesData.find((obj) => obj.value == selectedValue) || {};
                const garansiVal = selectedObj.garansi || "";
                const keteranganVal = selectedObj.keterangan || "";
                const price = parseFloat(selectedObj.price) || 0;

                isManualOverride = false;
                manualUnitPrice = 0;
                currentPrice = price;

                if (selectedValue == initStockId && initKeterangan !== "") {
                    $keteranganInput
                        .val(initKeterangan)
                        .prop("disabled", false);
                } else {
                    $keteranganInput.val(keteranganVal).prop("disabled", false);
                }

                if (selectedValue == initStockId && initGaransi === "ya") {
                    $garansiCheckbox
                        .prop("checked", true)
                        .prop("disabled", false);
                } else {
                    if (garansiVal !== "tidak") {
                        $garansiCheckbox
                            .prop("checked", true)
                            .prop("disabled", false);
                    } else {
                        $garansiCheckbox
                            .prop("checked", false)
                            .prop("disabled", false);
                    }
                }

                if ($qty.length && $subTotalInput.length) {
                    let qtyVal = parseInt($qty.val()) || 1;
                    if (qtyVal < 1) qtyVal = 1;

                    let subTotalAngka = currentPrice * qtyVal;
                    $subTotalInput.val(formatRupiah(subTotalAngka));
                    if ($totalBayarInput.length) calculateTotal(subTotalAngka);
                }
            });
        }
    });

    if ($subTotalInput.length) {
        $subTotalInput.on("input", function () {
            let clean = $(this)
                .val()
                .replace(/[^0-9]/g, "");
            if (clean === "") return;
            let angka = parseFloat(clean) || 0;
            $(this).val(formatRupiah(angka));

            if ($qty.length) {
                const currentQty = parseInt($qty.val()) || 1;
                if (currentQty > 0) {
                    isManualOverride = true;
                    manualUnitPrice = angka / currentQty;
                }
            }

            if ($totalBayarInput.length) calculateTotal(angka);
        });
    }

    if ($qty.length) {
        $qty.on("input", function () {
            let qtyVal = parseInt($(this).val()) || 1;
            if (qtyVal < 1) qtyVal = 1;

            let subTotalAngka;
            if (isManualOverride && manualUnitPrice > 0) {
                subTotalAngka = manualUnitPrice * qtyVal;
            } else {
                subTotalAngka = currentPrice * qtyVal;
            }

            if ($subTotalInput.length) {
                $subTotalInput.val(formatRupiah(subTotalAngka));
            }
            if ($totalBayarInput.length) calculateTotal(subTotalAngka);
        });
    }

    if ($diskonInput.length) {
        $diskonInput.on("input", function () {
            let discountVal = parseFloat($(this).val()) || 0;
            if (discountVal < 0) discountVal = 0;
            if (discountVal > 100) discountVal = 100;
            $(this).val(discountVal);

            if ($subTotalInput.length && $totalBayarInput.length) {
                let clean = $subTotalInput.val().replace(/[^0-9]/g, "");
                let subAngka = parseFloat(clean) || 0;
                calculateTotal(subAngka);
            }
        });
    }
});
