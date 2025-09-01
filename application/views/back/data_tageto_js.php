<script type="text/javascript">
    //NOTIFICATION Toast 
    function showToast(title, message, type = 'success') {
        const toastEl = $('#toastNotif');
        const toastTitle = $('#toast-title');
        const toastBody = $('#toast-body');
        const toastHeader = toastEl.find('.toast-header');
        let headerClass = 'bg-dark text-white';
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

        // LOAD Model/Type Product DB3
        let modelOptions = [];

        function getModelOptions(callback) {
            $.ajax({
                url: "<?= base_url('Back_tageto/get_model_data') ?>",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.error) {
                        showToast("Error", "❌ Failed to load model: " + res.error, "error");
                        callback([]);
                    } else {
                        modelOptions = res;
                        callback(res);
                    }
                },
                error: function(xhr) {
                    showToast("Error", "❌ Failed to connect to the model server", "error");
                    callback([]);
                }
            });
        }


        // LOAD DATA
        function load_data() {
            $.ajax({
                url: "<?= base_url('Back_tageto/load_data') ?>",
                dataType: "JSON",
                success: function(data) {
                    table.clear().draw();
                    let no = 1;
                    data.forEach(row => {
                        table.row.add([
                            no++,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="charging_date" value="${row.charging_date}">`,
                            `<select class="form-control model-dropdown text-center" data-row_id="${row.id}" data-column_name="model_id">
                                ${modelOptions.map(m => `<option value="${m.model}" ${row.model_id === m.model ? 'selected' : ''}>${m.model}</option>`).join('')}
                            </select>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="core_no" contenteditable>${row.core_no}</div>`,
                            `<select class="form-control cav-dropdown text-center" data-row_id="${row.id}" data-column_name="cav">
                                ${modelOptions
                                    .filter(m => m.model === row.model_id)
                                    .map(m => `
                                        <option disabled selected>Pola</option>
                                        <option value="${m.cav1}" ${row.cav === m.cav1 ? 'selected' : ''}>${m.cav1}</option>
                                        <option value="${m.cav2}" ${row.cav === m.cav2 ? 'selected' : ''}>${m.cav2}</option>
                                    `).join('')
                                }
                            </select>`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="process1_a" value="${parseFloat(row.process1_a).toFixed(1)}">`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="process1_b" value="${parseFloat(row.process1_b).toFixed(1)}">`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="process2_c" value="${parseFloat(row.process2_c).toFixed(1)}">`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="process2_d" value="${parseFloat(row.process2_d).toFixed(1)}">`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="process3_e" value="${parseFloat(row.process3_e).toFixed(1)}">`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="oil_pump" value="${parseFloat(row.oil_pump).toFixed(1)}">`,
                            `<select class="form-control form-select kijun_bosu3-dropdown text-center align-middle" data-row_id="${row.id}" data-column_name="kijun_bosu3">
                                <option value="" disabled selected>Kijun Bosu3</option>
                                <option value="OK"  ${row.kijun_bosu3 === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG"  ${row.kijun_bosu3 === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<input type="text" class="numpad form-control text-center align-middle" readonly data-row_id="${row.id}" data-column_name="bosu_cope" value="${parseFloat(row.bosu_cope).toFixed(1)}">`,
                            `<select class="form-control form-select by_gauge-dropdown text-center" data-row_id="${row.id}" data-column_name="by_gauge">
                                <option value="" disabled selected>By Gauge</option>    
                                <option value="OK" ${row.by_gauge === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG" ${row.by_gauge === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<select class="form-control form-select slope_angel-dropdown text-center align-middle" data-row_id="${row.id}" data-column_name="slope_angel">
                                <option value="" disabled selected>Process#2</option>
                                <option value="OK" ${row.slope_angel === 'OK' ? 'selected' : ''}>OK</option>
                                <option value="NG" ${row.slope_angel === 'NG' ? 'selected' : ''}>NG</option>
                            </select>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="sampling" contenteditable>${row.sampling}</div>`,
                            `<div class="table_data text-center align-middle" data-row_id="${row.id}" data-column_name="remark" contenteditable>${row.remark}</div>`,
                            `<div class="text-center align-middle">
                                <button class="btn btn-sm${row.gabari && row.gabari.toUpperCase() === 'YES' ? 'btn btn-success' : 'btn btn-danger'} btn-toggle-gabari" data-row_id="${row.id}" data-value="${row.gabari}">
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

        $(document).ready(function() {
            getModelOptions(() => {
                load_data();
            });
        });


        // Row hover
        $(document).on('focus', '.table_data, .numpad, select', function() {
            $(this).closest('tr').addClass('table-row-active');
        });

        $(document).on('blur', '.table_data, .numpad, select', function() {
            // Row Out Hover
            $(this).closest('tr').removeClass('table-row-active');
        });


        // Update Dropdown
        $(document).on('change', '.slope_angel-dropdown, .by_gauge-dropdown, .kijun_bosu3-dropdown', function() {
            let row_id = $(this).data('row_id');
            let column = $(this).data('column_name');
            let value = $(this).val();

            $.ajax({
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id: row_id,
                    table_column: column,
                    value: value
                },
                success: function() {
                    showToast("Success", "	✅ Data updated successfully. ", "success");
                },
                error: function() {
                    showToast("Error", "❌ Failed to update Data", "error");
                }
            });
        });


        // Update Dropdown Model/Product Type
        $(document).on('change', '.model-dropdown', function() {
            let selectedModel = $(this).val();
            let rowId = $(this).data('row_id');
            let cavDropdown = $(`.cav-dropdown[data-row_id="${rowId}"]`);
            let found = modelOptions.find(m => m.model === selectedModel);
            if (found) {
                cavDropdown.html(`
                <option disabled selected>Pola</option>
                <option value="${found.cav1}">${found.cav1}</option>
                <option value="${found.cav2}">${found.cav2}</option>
                `);
            }

            $.ajax({
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id: rowId,
                    table_column: 'model_id',
                    value: selectedModel
                },
                success: function() {
                    showToast("Success", "	✅ Data updated successfully.", "success");
                },
                error: function() {
                    showToast("Error", "❌ Failed to update Model", "error");
                }
            });
        });


        // Update Dropdown Cav/Pola
        $(document).on('change', '.cav-dropdown', function() {
            let value = $(this).val();
            let id = $(this).data('row_id');

            $.ajax({
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id: id,
                    table_column: 'cav',
                    value: value
                },
                success: function() {
                    showToast("Success", "	✅ Data updated successfully.", "success");
                },
                error: function() {
                    showToast("Error", "❌ Failed to update Pola", "error");
                }
            });
        });


        // INSERT DATA FORM (Process Date, Charging Date, Type Product)
        $('#form-data').on('submit', function(e) {
            e.preventDefault();

            // get id model selected
            let selectedModelId = $('input[name="model_id"]:checked').val();
            let selectedModelData = modelOptions.find(m => m.model === selectedModelId);
            let formData = {
                process_date: $('#process_date').val(),
                charging_date: $('#charging_date').val(),
                model_id: selectedModelId,
                cav: selectedModelData ? selectedModelData.cav1 : '', // get cav1 automatic from model
                gabari: $('#confirm_check').is(':checked') ? 'YES' : 'NO'
            };

            // send data via Ajax
            $.ajax({
                url: "<?= base_url('Back_tageto/insert') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(data) {
                    showToast("Success", "✅ New record added successfully.", "success");
                    $('#form-data')[0].reset();
                    load_data();
                },
                error: function(xhr) {
                    showToast("Error", " ❌ Oops! An error has occurred : " + xhr.responseText, "error");
                }
            });
        });


        //UPDATED DATA
        $(document).on('blur', '.table_data', function() {
            let id = $(this).data('row_id');
            let column = $(this).data('column_name');
            let value = $(this).text().trim();
            $.ajax({
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id,
                    table_column: column,
                    value
                },
                success: function() {
                    showToast("Success", "✅ New record added successfully.", "success");
                },
                error: function() {
                    showToast("Error", "❌ Failed to update data.", "error");
                }
            });
        });

        //DELETED DATA
        $(document).on('click', '.btn_delete', function() {
            let id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure you want to delete the data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Back_tageto/delete') ?>",
                        method: "POST",
                        data: {
                            id
                        },
                        success: function() {
                            showToast("Success", "✅ New record added successfully.", "success");
                            load_data();
                        },
                        error: function() {
                            showToast("Error", " ❌ Data could not be deleted. Please check and try again.", "error");
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
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id: id,
                    table_column: 'gabari',
                    value: newValue
                },
                success: function() {
                    showToast("Success", "✅ Gabari update to " + newValue, "success");
                    btn
                        .text(newValue)
                        .data('value', newValue)
                        .removeClass('btn-success btn-danger btn-warning')
                        .addClass(newValue === 'YES' ? 'btn-success' : 'btn-danger');
                },
                error: function() {
                    showToast("Error", " ❌ The data update failed. Please check and try again", "error");
                }
            });
        });


        // NUMPAD Numerik Pad
        let activeInput = null;
        $(document).on('click', '.numpad', function(e) {
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
                url: "<?= base_url('Back_tageto/update') ?>",
                method: "POST",
                data: {
                    id: activeInput.data('row_id'),
                    table_column: activeInput.data('column_name'),
                    value: newVal
                },
                success: function() {
                    showToast("Success", "✅ New record added successfully.", "success");
                },
                error: function() {
                    showToast("Error", "❌ The data update failed. Please check and try again", "error");
                }
            });

            activeInput = null;
        };
    });
</script>