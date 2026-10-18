        </main>
        <!-- Footer Info -->
        <footer class="bg-white border-top py-3 px-4 text-center text-sm-start d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <span class="small text-muted">&copy; <?= date('Y'); ?> <strong>RBQ Al Fatih</strong> - Sistem Manajemen Rumah Belajar Quran.</span>
            <span class="small text-muted">Metode Ummi Indonesia</span>
        </footer>
    </div>

    <!-- Scripts: jQuery, Bootstrap 5, DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Sidebar Toggle on Mobile
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('show');
            });

            // Initialize DataTables default
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    language: {
                        search: "Cari data:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data yang ditampilkan",
                        infoFiltered: "(disaring dari _MAX_ total data)",
                        zeroRecords: "Data tidak ditemukan",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "&raquo;",
                            previous: "&laquo;"
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
