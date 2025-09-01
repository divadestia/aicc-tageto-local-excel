<script type="text/javascript">
    //NOTIFICATION 
    function showToast(title, message, type = 'success') {
        const toastEl = $('#toastNotif');
        const toastTitle = $('#toast-title');
        const toastBody = $('#toast-body');
        const toastHeader = toastEl.find('.toast-header');

        let headerClass = 'bg-success text-white';
        if (type === 'error') headerClass = 'bg-danger text-white';
        else if (type === 'warning') headerClass = 'bg-warning text-dark';
        else if (type === 'info') headerClass = 'bg-info text-white';

        toastHeader.removeClass('bg-success bg-danger bg-warning bg-info text-white text-dark')
            .addClass(headerClass);

        toastTitle.text(title);
        toastBody.text(message);

        toastEl.toast({
            delay: 3000
        });
        toastEl.toast('show');
    }

    //SHOW & SEARCH
    $(document).ready(function() {
        let table = $('#datatable1').DataTable({
            columnDefs: [{
                targets: [0],
                orderable: false
            }],
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            pageLength: 10,
            responsive: true,
            destroy: true
        });



        // LOAD DATA
        function load_data() {
            $.ajax({
                url: "<?= base_url('livetable/load_data') ?>",
                dataType: "JSON",
                success: function(data) {
                    table.clear().draw();
                    let no = 1;
                    data.reverse().forEach(row => {
                        table.row.add([
                            no++,
                            `<div class="table_data bg-light text-center align-middle border rounded px-2 py-1 text-muted" data-row_id="${row.id}" data-column_name="process_date" contenteditable>${row.process_date}</div>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="charging_date" contenteditable>${row.charging_date}</div>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="product_type" contenteditable>${row.product_type}</div>`,
                            `<div class="table_data align-middle " data-row_id="${row.id}" data-column_name="first_name" contenteditable>${row.first_name}</div>`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="bosu_cope" value="${parseFloat(row.bosu_cope).toFixed(1)}">`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<select class="form-control form-select kijun_bosu-dropdown text-center" data-row_id="${row.id}" data-column_name="kijun_bosu">
                                <option value="OK" ${row.kijun_bosu === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG" ${row.kijun_bosu === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<input type="text" class="age-input form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="age" value="${parseFloat(row.age).toFixed(1)}">`,
                            `<select class="form-control form-select kijun_bosu-dropdown text-center" data-row_id="${row.id}" data-column_name="product_type">
                                <option value="OK" ${row.kijun_bosu === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG" ${row.kijun_bosu === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<select class="form-control form-select kijun_bosu-dropdown text-center" data-row_id="${row.id}" data-column_name="kijun_bosu">
                                <option value="OK" ${row.kijun_bosu === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG" ${row.kijun_bosu === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="last_name" contenteditable>${row.last_name}</div>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="last_name" contenteditable>${row.last_name}</div>`,
                            `<div class="text-center align-middle">
                                <button class="btn btn-sm ${row.gabari && row.gabari.toUpperCase() === 'YES' ? 'btn-success' : 'btn-danger'} btn-toggle-gabari" data-row_id="${row.id}" data-value="${row.gabari}">
                                     ${row.gabari || 'No'}
                                </button>
                            </div>`,
                            `<div class="text-center align-middle"><button type="button" class="btn btn-danger btn-sm btn_delete" id="${row.id}">
                                <i class="fas fa-trash-alt"></i>
                                </button></div>`
                        ]).draw(false);
                    });
                }
            });
        }
        load_data();


        //INSERT DATA 
        $('#form-data').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                process_date: $('#process_date').val(),
                charging_date: $('#charging_date').val(),
                product_type: $('input[name="product_type"]:checked').val(),
                gabari: $('#confirm_check').is(':checked') ? 'YES' : 'NO'
            };

            $.ajax({
                url: "<?= base_url('LiveTable/insert') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(data) {
                    showToast("Success", "Successfully Added Data.", "success");
                    $('#form-data')[0].reset();
                    load_data();
                },
                error: function(xhr) {
                    showToast("Error", "Terjadi kesalahan: " + xhr.responseText, "error");
                }
            });
        });


        //UPDATED DATA
        $(document).on('blur', '.table_data', function() {
            let id = $(this).data('row_id');
            let column = $(this).data('column_name');
            let value = $(this).text().trim();
            $.ajax({
                url: "<?= base_url('livetable/update') ?>",
                method: "POST",
                data: {
                    id,
                    table_column: column,
                    value
                },
                success: function() {
                    showToast("Success", "Successfully Added Data.", "success");
                },
                error: function() {
                    showToast("Error", "Gagal memperbarui data.", "error");
                }
            });
        });

        //DELETED DATA
        $(document).on('click', '.btn_delete', function() {
            let id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure to Delete ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('livetable/delete') ?>",
                        method: "POST",
                        data: {
                            id
                        },
                        success: function() {
                            showToast("Success", "Successfully Added Data.", "success");
                            load_data();
                        },
                        error: function() {
                            showToast("Error", "Gagal menghapus data.", "error");
                        }
                    });
                }
            });
        });


        // TOGGLE GABARI BUTTON 
        $(document).on('click', '.btn-toggle-gabari', function() {
            let btn = $(this);
            let current = btn.data('value');
            let newValue = current === 'YES' ? 'NO' : 'YES';
            let id = btn.data('row_id');

            $.ajax({
                url: "<?= base_url('livetable/update') ?>",
                method: "POST",
                data: {
                    id: id,
                    table_column: 'gabari',
                    value: newValue
                },
                success: function() {
                    showToast("Success", "Gabari updated to " + newValue, "success");
                    btn
                        .text(newValue)
                        .data('value', newValue)
                        .removeClass('btn-success btn-danger')
                        .addClass(newValue === 'YES' ? 'btn-success' : 'btn-danger');
                },
                error: function() {
                    showToast("Error", "Gagal mengubah nilai Gabari", "error");
                }
            });
        });


        // NUMPAD
        let activeInput = null;
        $(document).on('click', '.age-input', function(e) {
            e.stopPropagation();
            activeInput = $(this);
            $('#numpadDisplay').val(activeInput.val());
            const off = activeInput.offset();
            $('#numpadContainer').css({
                top: off.top + activeInput.outerHeight(),
                left: off.left
            }).show();
        });

        $(document).on('click', function() {
            $('#numpadContainer').hide();
            activeInput = null;
        });

        $('#numpadContainer').on('click', e => e.stopPropagation());

        window.np = function(v) {
            $('#numpadDisplay').val($('#numpadDisplay').val() + v);
        };
        window.tn = function() {
            let d = $('#numpadDisplay'),
                val = d.val();
            d.val(val.startsWith('-') ? val.slice(1) : ('-' + val));
        };
        window.clearNp = function() {
            $('#numpadDisplay').val('');
        };
        window.cancelNp = function() {
            $('#numpadContainer').hide();
            activeInput = null;
        };
        window.okNp = function() {
            if (!activeInput) return;
            const newVal = $('#numpadDisplay').val();
            activeInput.val(newVal);
            $('#numpadContainer').hide();

            $.ajax({
                url: "<?= base_url('livetable/update') ?>",
                method: "POST",
                data: {
                    id: activeInput.data('row_id'),
                    table_column: activeInput.data('column_name'),
                    value: newVal
                },
                success: function() {
                    showToast("Success", "SUccessfully Added Data.", "success");
                },
                error: function() {
                    showToast("Error", "Gagal memperbarui age.", "error");
                }
            });

            activeInput = null;
        };
    });
</script>