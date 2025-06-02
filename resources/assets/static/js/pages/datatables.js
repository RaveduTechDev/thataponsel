$(document).ready(function () {
    // Inisialisasi DataTables
    var table = $("#table1").DataTable();

    $("div.dataTables_filter", table.table().container()).css({
        display: "flex",
        "align-items": "center",
        "justify-content": "flex-end",
        gap: "10px",
    });

    // Pindahkan loading indicator ke samping kiri search filter DataTable
    $("div.dataTables_filter", table.table().container()).prepend(
        $("#loading")
    );

    // Fungsi untuk mengambil settings JSON berdasarkan group (data-name)
    function getSettings(name) {
        var settings = localStorage.getItem("column_settings_" + name);
        return settings ? JSON.parse(settings) : {};
    }

    // Fungsi untuk menyimpan settings JSON ke localStorage
    function saveSettings(name, settings) {
        localStorage.setItem(
            "column_settings_" + name,
            JSON.stringify(settings)
        );
    }

    // Inisialisasi tiap checkbox dengan settings dari localStorage
    $('#toggle-columns input[type="checkbox"]').each(function () {
        var colIndex = $(this).data("column");
        var name = $(this).data("name");

        var settings = getSettings(name);
        var isVisible = settings.hasOwnProperty(colIndex)
            ? settings[colIndex]
            : $(this).prop("checked");

        $(this).prop("checked", isVisible);
        settings[colIndex] = isVisible;
        table.column(colIndex).visible(isVisible, false);

        saveSettings(name, settings);
    });
    table.columns.adjust().draw();

    // Event handler untuk perubahan checkbox secara realtime
    $('#toggle-columns input[type="checkbox"]').on("change", function () {
        var colIndex = $(this).data("column");
        var name = $(this).data("name");
        var isChecked = $(this).prop("checked");

        // Tampilkan loading indicator (sekarang di samping search)
        $("#loading").fadeIn(150);

        // Update settings JSON
        var settings = getSettings(name);
        settings[colIndex] = isChecked;
        saveSettings(name, settings);

        // Ubah visibilitas kolom di DataTable
        table.column(colIndex).visible(isChecked, false);

        // Adjust dan draw tabel, lalu sembunyikan loading indicator
        setTimeout(function () {
            table.columns.adjust().draw();
            $("#loading").fadeOut(150);
        }, 100);
    });

    $("#dropdown-columns").appendTo(
        $("div.dataTables_filter", table.table().container())
    );
});

var pagingTypes = $(window).width() < 600 ? "simple" : "simple_numbers";

$(window).resize(function () {
    let newPagingTypes = $(window).width() < 600 ? "simple" : "simple_numbers";
    if (newPagingTypes !== pagingTypes) {
        pagingTypes = newPagingTypes;
        jquery_datatable.destroy();
        jquery_datatable = $("#table1").DataTable({
            pagingType: pagingTypes,
        });
    }
});

let jquery_datatable = $("#table1").DataTable({
    responsive: true,
    pagingType: pagingTypes,
    autoWidth: false,
    order: [],
    language: {
        search: "Cari: ",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari total 0 data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        zeroRecords: "Data tidak ditemukan",
        emptyTable: "Tidak ada data yang tersedia",
        paginate: {
            first: "Awal",
            last: "Akhir",
            next: "Berikutnya",
            previous: "Sebelumnya",
        },
        columnDefs: [{ orderable: false, targets: [0, -1] }],
        dom:
            "<'row'<'col-3'l><'col-9 d-flex justify-content-end align-items-center'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-4'i><'col-8'p>>",
    },
});

const setTableColor = () => {
    document
        .querySelectorAll(".dataTables_paginate .pagination")
        .forEach((dt) => {
            dt.classList.add("pagination-danger");
        });
};
setTableColor();
jquery_datatable.on("draw", setTableColor);

let customized_datatable = $("#table2").DataTable({
    responsive: true,
    pagingType: "simple",
    dom:
        "<'row'<'col-3'l><'col-9'f>>" +
        "<'row dt-row'<'col-sm-12'tr>>" +
        "<'row'<'col-4'i><'col-8'p>>",
    language: {
        info: "Page _PAGE_ of _PAGES_",
        lengthMenu: "_MENU_ ",
        search: "",
        searchPlaceholder: "Search..",
    },
});

// gunakan Set untuk menampung ID yang dipilih
const selectedIds = new Set();

// setiap kali user nge-klik checkbox baris
$(document).on("change", ".row-checkbox", function () {
    const id = $(this).val();
    if (this.checked) selectedIds.add(id);
    else selectedIds.delete(id);
    updateSelectAll();
});

// saat “select all” di header diklik
$("#select-all").on("click", function () {
    const cek = this.checked;
    $(".row-checkbox:visible").each(function () {
        $(this).prop("checked", cek).trigger("change");
    });
});

// ketika DataTable redraw (user ganti page / cari / sort)
$("#table1").on("draw.dt", function () {
    // restore state checkbox
    $(".row-checkbox").each(function () {
        $(this).prop("checked", selectedIds.has($(this).val()));
    });
    updateSelectAll();
});

function updateSelectAll() {
    const visible = $(".row-checkbox:visible");
    const total = visible.length;
    const ceked = visible.filter(":checked").length;
    $("#select-all").prop("checked", total > 0 && ceked === total);

    buttonPDF();
}

function buttonPDF() {
    const btnPDF = $("#btn-export-pdf");
    btnPDF.css("cursor", selectedIds.size === 0 ? "no-allowed" : "pointer");
    btnPDF.prop("disabled", selectedIds.size === 0);
}

// Event click tombol export
$(".btn-export").on("click", function () {
    const action = $(this).data("action");
    const idsArray = Array.from(selectedIds);
    const form = $("#form-export");

    if (action === "pdf") {
        // PDF harus ada pilihan checkbox
        if (idsArray.length === 0) {
            alert("Pilih minimal 1 invoice untuk export PDF");
            return;
        }

        const firstId = idsArray[0];
        const firstInvoice = $(`.row-checkbox[value="${firstId}"]`).data(
            "invoice"
        );
        const baseRoute = form.data("route");
        const finalRoute = baseRoute.replace("__INVOICE__", firstInvoice);

        form.attr("action", finalRoute);
        $("#ids").val(idsArray.join(","));
    } else if (action === "excel") {
        // Excel bisa submit dengan atau tanpa pilihan
        const baseRoute = form.data("route");

        // Kalau ada pilihan, pakai invoice pertama
        // Kalau tidak ada pilihan, pakai 'all' (atau sesuai handle di route/controller)
        let invoiceForRoute = "all";
        if (idsArray.length > 0) {
            const firstId = idsArray[0];
            invoiceForRoute = $(`.row-checkbox[value="${firstId}"]`).data(
                "invoice"
            );
            $("#ids").val(idsArray.join(","));
        } else {
            $("#ids").val("");
        }

        const finalRoute = baseRoute.replace("__INVOICE__", invoiceForRoute);
        form.attr("action", finalRoute);
    }

    $("#export").val(action);
    form.submit();
});
