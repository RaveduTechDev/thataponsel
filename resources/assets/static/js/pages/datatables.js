$(document).ready(function () {
    // Inisialisasi DataTables
    var table = $("#table1").DataTable();

    $("div.dataTables_filter", table.table().container()).css({
        display: "flex",
        "align-items": "center",
        "justify-content": "flex-end",
        gap: "10px",
    });

    // Event handler untuk checkbox
    $('#toggle-columns input[type="checkbox"]').on("change", function () {
        // Ambil indeks kolom dari atribut data-column
        var column = table.column($(this).attr("data-column"));
        // Toggle visibilitas kolom berdasarkan status checkbox
        column.visible(this.checked);
    });

    // Sembunyikan kolom yang tidak dicentang saat inisialisasi
    $('#toggle-columns input[type="checkbox"]').each(function () {
        var column = table.column($(this).attr("data-column"));
        column.visible(this.checked);
    });

    $("#dropdown-columns").appendTo(
        $("div.dataTables_filter", table.table().container())
    );
});

let jquery_datatable = $("#table1").DataTable({
    responsive: true,
    scrollX: false,
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
        columnDefs: [
            { width: "100px", targets: 0 },
            { width: "100px", targets: 1 },
            { width: "100px", targets: 2 },
            { width: "100px", targets: 3 },
            { width: "100px", targets: 4 },
            { width: "100px", targets: 5 },
            { width: "100px", targets: 6 },
            { width: "100px", targets: 7 },
            { width: "100px", targets: 8 },
            { width: "100px", targets: 9 },
            { width: "100px", targets: 10 },
            { width: "100px", targets: 11 },
            { width: "100px", targets: 12 },
            { width: "100px", targets: 13 },
            { width: "100px", targets: 14 },
            { width: "100px", targets: 15 },
            { width: "100px", targets: 16 },
            { orderable: false, targets: [0, -1] },
        ],
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
