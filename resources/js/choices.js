import Choices from "choices.js";

$(document).ready(function () {
    // Fungsi untuk memformat angka ke Rupiah
    function formatRupiah(angka) {
        angka = parseFloat(angka) || 0;
        return (
            "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
    }

    $(".select-data").each(function () {
        const choicesData = [];
        const $select = $(this);
        const placeholderText = $select.data("placeholder");
        // Cek apakah select memiliki attribute data-check-selected="true"
        const checkSelected = $select.attr("data-check-selected") === "true";
        // Cek apakah select ini digunakan untuk kalkulasi (hanya select dengan data-calc=true yang memicu kalkulasi)
        const isCalculateSelect =
            $select.data("calc") === true || $select.data("calc") === "true";

        // Iterasi setiap <option> di dalam select
        $select.find("option").each(function () {
            const value = $(this).attr("value");
            // Lewati placeholder (value kosong)
            if (value !== "") {
                const label = $(this).text().trim();
                const description = $(this).data("description") || "";
                const price = $(this).data("price") || 0; // ambil nilai price
                let isSelected = false;
                if (checkSelected) {
                    isSelected = $(this).is(":selected");
                }
                choicesData.push({
                    value: value,
                    label: label,
                    description: description,
                    selected: isSelected,
                    price: price, // simpan property price
                });
            }
        });

        // Hapus isi select sehingga Choices.js akan menggunakan data dari choicesData
        $select.html("");

        const element = $select[0];
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

        // Jika select ini adalah select untuk kalkulasi, attach event handler
        if (isCalculateSelect) {
            $(element).on("change", function () {
                // Ambil nilai option terpilih dari Choices.js
                var selectedValue = choices.getValue(true);
                // Cari data price dari choicesData berdasarkan value yang terpilih
                var price = 0;
                choicesData.forEach(function (item) {
                    if (item.value == selectedValue) {
                        price = item.price;
                    }
                });
                // Update input sub-total dengan format Rupiah
                $("#sub-total").val(formatRupiah(price));
                calculateTotal(price);
            });
        }
    });

    // Event input untuk diskon, dengan validasi max diskon 100
    $("#diskon").on("input", function () {
        var discountVal = parseFloat($(this).val()) || 0;
        if (discountVal > 100) {
            $(this).val(100);
            discountVal = 100;
        }
        // Ambil nilai price dari sub-total, hilangkan karakter non-digit
        var priceString = $("#sub-total")
            .val()
            .replace(/[^0-9]/g, "");
        var price = parseFloat(priceString) || 0;
        calculateTotal(price);
    });

    // Fungsi perhitungan jumlah bayar dengan diskon persenan,
    // nilai diskon dibulatkan agar tidak ada angka desimal
    function calculateTotal(price) {
        var discountPercent = parseFloat($("#diskon").val()) || 0;
        var discountAmount = Math.round((price * discountPercent) / 100);
        var total = price - discountAmount;
        $("#total-bayar").val(formatRupiah(total));
    }
});
