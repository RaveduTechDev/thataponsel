let jquery_datatable = $("#table1").DataTable({
    responsive: true,
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
    },
});
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

const setTableColor = () => {
    document
        .querySelectorAll(".dataTables_paginate .pagination")
        .forEach((dt) => {
            dt.classList.add("pagination-danger");
        });
};
setTableColor();
jquery_datatable.on("draw", setTableColor);
