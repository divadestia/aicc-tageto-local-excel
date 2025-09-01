<script type="text/javascript">
    var base_url = $('#base_url').val();
    var url_api = base_url + 'api/';
    var current_url = $('#current_url').val();

    $(document).ready(function() {
        $('.select2').select2();

        // isi model, lalu isi cavity sesuai model (tanpa load data)
        get_s_model().then(() => {
            const initModel = get_param('s_model');
            const initCavity = get_param('s_cavity');
            const pStart = get_param('s_start_date');
            const pEnd = get_param('s_end_date');
            if (pStart && pEnd) {
                $('#date-range-label').text(
                    pStart.split('-').reverse().join('-') + ' sd ' + pEnd.split('-').reverse().join('-')
                );
            }

            if (initModel) {
                $('#s_model').val(initModel).trigger('change.select2');
                cavity_selected(initModel, initCavity);
                if (initCavity) $('#s_cavity').val(initCavity).trigger('change.select2');
            }
        });

        $('#accordion-group-model').html(no_data());

        // saat model berubah, hanya refresh list cavity (tanpa load data)
        $('#s_model').on('change', function() {
            const prevCavity = $('#s_cavity').val();
            cavity_selected($(this).val(), prevCavity);
        });

        // submit tombol Search → load data via AJAX
        $('#form-search').on('submit', function(e) {
            e.preventDefault();
            // opsional: update query string biar bisa di-bookmark
            form_filters();
            const sd = $('#s_start_date').val();
            const ed = $('#s_end_date').val();
            $('#date-range-label').text(
                (sd && ed) ? sd.split('-').reverse().join('-') + ' sd ' + ed.split('-').reverse().join('-') : ''
            );

            show_data();
        });

        // expand/collapse all
        $('#myform :checkbox').off('change').on('change', function() {
            if ($(this).is(':checked')) {
                $('.xcollapse').attr('class', 'xcollapse collapse show');
                $('.xcollapsed').removeClass('collapsed', '');
            } else {
                $('.xcollapse').attr('class', 'xcollapse collapse');
                $('.xcollapsed').addClass('collapsed');
            }
        });
    });

    // ===== util kecil =====
    function get_param(name) {
        const u = new URL(window.location.href);
        return u.searchParams.get(name) || '';
    }

    function form_filters() {
        const u = new URL(window.location.href);
        ['s_start_date', 's_end_date', 's_model', 's_shift', 's_cavity'].forEach(id => {
            const v = $('#' + id).val() || '';
            if (v) u.searchParams.set(id, v);
            else u.searchParams.delete(id);
        });
        window.history.replaceState({}, '', u.toString());
    }

    function no_data() {
        return `<div class="col-lg-12">
      <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-info"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        No Recorded Data !</b>
      </div>
    </div>`;
    }

    function set_loading(is) {
        if (is) {
            $('#accordion-group-model').html(`
        <div class="p-4 text-center">
          <div class="spinner-border" role="status" aria-hidden="true"></div>
          <div class="mt-2">Loading data...</div>
        </div>`);
            $('#filter_btn').prop('disabled', true);
        } else {
            $('#filter_btn').prop('disabled', false);
        }
    }

    // ===== Model & Cav =====
    function get_s_model() {
        return $.ajax({
            type: "POST",
            url: url_api + 'master/model-molding/show-data',
            dataType: "JSON",
            data: {},
            success: function(res) {
                let opt = '<option value="">Choose Model Name</option>';
                (res.data_model || []).forEach(function(m) {
                    if (m.category === 'CBL') opt += `<option value="${m.id}">${m.model}</option>`;
                });
                $('#s_model').html(opt);
            },
            error: function(xhr) {
                console.error('Failed to fetch model:', xhr?.statusText || 'error');
            }
        });
    }

    function cavity_selected(model_id = '', preserveCavity = '') {
        if (!model_id) {
            $('#s_cavity').html('<option value="">Choose Cavity</option>');
            return;
        }
        $.ajax({
            type: "POST",
            url: url_api + 'master/model-molding/show-data',
            dataType: "JSON",
            data: {
                id: model_id
            },
            success: function(res) {
                const cavSet = new Set();
                const md = (res.data_model && res.data_model[0]) || {};
                if (md.cav1) cavSet.add(md.cav1);
                if (md.cav2) cavSet.add(md.cav2);

                let opt = '<option value="">Choose Cavity</option>';
                cavSet.forEach(c => opt += `<option value="${c}">${c}</option>`);
                $('#s_cavity').html(opt);
                if (preserveCavity && cavSet.has(preserveCavity)) {
                    $('#s_cavity').val(preserveCavity);
                }
                $('#s_cavity').trigger('change.select2');
            },
            error: function(xhr) {
                console.error('Failed to fetch cavity:', xhr?.statusText || 'error');
            }
        });
    }



    function show_data() {
        const s_model = $('#s_model').val();
        const s_start_date = $('#s_start_date').val();
        const s_end_date = $('#s_end_date').val();
        const s_shift = $('#s_shift').val();
        const s_cavity = $('#s_cavity').val();

        if (!(s_start_date && s_end_date)) {
            $('#accordion-group-model').html(no_data());
            return;
        }

        set_loading(true);
        const $wrap = $('#accordion-group-model').empty();

        // SHOW ALL DATA START DATE & END DATE
        if (!s_model) {
            const oneCard = `
      <div class="card mb-1">
        <div class="col-lg-12">
          <ul class="nav nav-tabs mt-3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#dataMain" role="tab">
                <i class="fas fa-table"></i> Data (All Models)
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#summaryMain" role="tab">
                <i class="fas fa-chart-pie"></i> Summary
              </a>
            </li>
          </ul>

          <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="dataMain" role="tabpanel">
              <div style="max-width:auto;overflow-x:auto;">
                <table id="datatable_main" class="table table-hover dt-responsive nowrap" style="width:100%;">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-center align-middle">No</th>
                      <th class="text-center align-middle">Charging Date</th>
                      <th class="text-center align-middle">Product</th>
                      <th class="text-center align-middle">Cavity</th>
                      <th class="text-center align-middle">No Core</th>
                      <th class="text-center align-middle">Process 1A</th>
                      <th class="text-center align-middle">Process 1B</th>
                      <th class="text-center align-middle">Process 2C</th>
                      <th class="text-center align-middle">Process 2D</th>
                      <th class="text-center align-middle">Process 3E</th>
                      <th class="text-center align-middle">Oil Pump</th>
                      <th class="text-center align-middle">Kijun Bosu 3</th>
                      <th class="text-center align-middle">Bosu Cope</th>
                      <th class="text-center align-middle">By Gauge</th>
                      <th class="text-center align-middle">Proses #2</th>
                      <th class="text-center align-middle">Sampling</th>
                      <th class="text-center align-middle">Remark</th>
                      <th class="text-center align-middle">Gabari Check</th>
                      <th class="text-center align-middle">Shift</th>
                      <th class="text-center align-middle">PIC</th>
                    </tr>
                  </thead>
                  <tbody id="show_data_main"></tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane" id="summaryMain" role="tabpanel">
              <div style="max-width:auto;overflow-x:auto;">
                <table class="table table-hover dt-responsive nowrap" style="width:100%;">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-center" style="width:5%;white-space:nowrap;"">No</th>
                      <th class="text-left"  style="width:80%;">Model Name</th>
                      <th class="text-right" style="width:10%;white-space:nowrap;">Total</th>
                    </tr>
                  </thead>
                  <tbody id="show_data_summary_main">
                    <tr><td colspan="3" class="text-center">Loading...</td></tr>
                  </tbody>
                  <tfoot id="show_total_summary_main" class="bg-light font-weight-bold"></tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>`;
            $wrap.append(oneCard);

            // SHOW SEMUA model sesuai filter tanggal/shift/cavity
            $.ajax({
                url: url_api + 'production/tageto-report/show-data',
                type: 'POST',
                data: {
                    s_start_date,
                    s_end_date,
                    s_model: '',
                    s_shift,
                    s_cavity,
                    current_url
                },
                success: function(resp) {
                    if ($.fn.DataTable.isDataTable('#datatable_main')) {
                        $('#datatable_main').DataTable().clear().destroy();
                    }
                    $('#show_data_main').html(resp);
                    $('#datatable_main').DataTable({
                        order: [
                            [0, 'asc']
                        ],
                        columnDefs: [{
                            targets: [0],
                            orderable: false
                        }]
                    });
                },
                error: function() {
                    $('#show_data_main').html('<tr><td colspan="20" class="text-center text-danger">Failed to load data</td></tr>');
                }
            });

            // SUMMARY ALL DATA
            $.ajax({
                url: url_api + 'production/tageto-report/show-data-summary',
                type: 'POST',
                dataType: 'json',
                data: {
                    s_start_date,
                    s_end_date,
                    s_model: '',
                    s_shift,
                    s_cavity,
                    current_url
                },
                success: function(resp) {
                    $('#show_data_summary_main').html(resp?.tbody || '<tr><td colspan="3" class="text-center">No data</td></tr>');
                    $('#show_total_summary_main').html(resp?.tfoot || '');
                },
                complete: function() {
                    set_loading(false);
                }
            });

            return;
        }

        // SHOW DENGAN FILTER MODEL TERTENTU
        $.ajax({
            type: "POST",
            url: url_api + 'master/model-molding/show-data',
            dataType: "JSON",
            data: {
                id: s_model
            },
            success: function(result) {
                const models = result.data_model || [];
                if (!models.length) {
                    $wrap.html(no_data());
                    set_loading(false);
                    return;
                }

                models.forEach(function(v) {
                    const cardHtml = `
          <div class="card mb-1">
            <div class="col-lg-12">
              <ul class="nav nav-tabs mt-3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#data${v.id}" role="tab">
                    <i class="fas fa-table"></i> Data — ${v.model}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#summary${v.id}" role="tab">
                    <i class="fas fa-chart-pie"></i> Summary
                  </a>
                </li>
              </ul>

              <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="data${v.id}" role="tabpanel">
                  <div style="max-width:auto;overflow-x:auto;">
                    <table id="datatable${v.id}" class="table table-hover dt-responsive nowrap" style="width:100%;">
                      <thead class="bg-light">
                        <tr>
                          <th class="text-center align-middle">No</th>
                          <th class="text-center align-middle">Charging Date</th>
                          <th class="text-center align-middle">Product</th>
                          <th class="text-center align-middle">Cavity</th>
                          <th class="text-center align-middle">No Core</th>
                          <th class="text-center align-middle">Process 1A</th>
                          <th class="text-center align-middle">Process 1B</th>
                          <th class="text-center align-middle">Process 2C</th>
                          <th class="text-center align-middle">Process 2D</th>
                          <th class="text-center align-middle">Process 3E</th>
                          <th class="text-center align-middle">Oil Pump</th>
                          <th class="text-center align-middle">Kijun Bosu 3</th>
                          <th class="text-center align-middle">Bosu Cope</th>
                          <th class="text-center align-middle">By Gauge</th>
                          <th class="text-center align-middle">Proses #2</th>
                          <th class="text-center align-middle">Sampling</th>
                          <th class="text-center align-middle">Remark</th>
                          <th class="text-center align-middle">Gabari Check</th>
                          <th class="text-center align-middle">Shift</th>
                          <th class="text-center align-middle">PIC</th>
                        </tr>
                      </thead>
                      <tbody id="show_data_${v.id}"></tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane" id="summary${v.id}" role="tabpanel">
                  <div style="max-width:auto;overflow-x:auto;">
                    <table class="table table-hover dt-responsive nowrap" style="width:100%;">
                      <thead class="bg-light">
                        <tr>
                          <th class="text-center" style="width:5%;white-space:nowrap;"">No</th>
                          <th class="text-left"  style="width:80%;">Model Name</th>
                          <th class="text-right" style="width:10%;white-space:nowrap;">Total</th>
                        </tr>
                      </thead>
                      <tbody id="show_data_summary_${v.id}">
                        <tr><td colspan="3" class="text-center">Loading...</td></tr>
                      </tbody>
                      <tfoot id="show_total_summary_${v.id}" class="bg-light font-weight-bold"></tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>`;
                    $wrap.append(cardHtml);

                    // DATA (khusus model)
                    $.ajax({
                        url: url_api + 'production/tageto-report/show-data',
                        type: 'POST',
                        data: {
                            s_start_date,
                            s_end_date,
                            s_model: v.id,
                            s_shift,
                            s_cavity,
                            current_url
                        },
                        success: function(resp) {
                            if ($.fn.DataTable.isDataTable('#datatable' + v.id)) {
                                $('#datatable' + v.id).DataTable().clear().destroy();
                            }
                            $('#show_data_' + v.id).html(resp);
                            $('#datatable' + v.id).DataTable({
                                order: [
                                    [1, 'asc']
                                ],
                                columnDefs: [{
                                    targets: [0],
                                    orderable: false
                                }]
                            });
                        },
                        error: function() {
                            $('#show_data_' + v.id).html('<tr><td colspan="20" class="text-center text-danger">Failed to load data.</td></tr>');
                        }
                    });

                    // SUMMARY (khusus model)
                    $.ajax({
                        url: url_api + 'production/tageto-report/show-data-summary',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            s_start_date,
                            s_end_date,
                            s_model: v.id,
                            s_shift,
                            s_cavity,
                            current_url
                        },
                        success: function(resp) {
                            $('#show_data_summary_' + v.id).html(resp?.tbody || '<tr><td colspan="3" class="text-center">No data</td></tr>');
                            $('#show_total_summary_' + v.id).html(resp?.tfoot || '');
                        }
                    });
                });

                set_loading(false);
            },
            error: function() {
                $wrap.html(no_data());
                set_loading(false);
            }
        });
    }


    // // ===== Export Excel (tetap butuh cavity) =====
    // function export_excel() {
    //     const s_model = $('#s_model').val();
    //     const s_start_date = $('#s_start_date').val();
    //     const s_end_date = $('#s_end_date').val();
    //     const s_shift = $('#s_shift').val();
    //     const s_cavity = $('#s_cavity').val();

    //     if (!s_start_date) return error_text("Date Harus Diisi !", "custom");
    //     if (!s_end_date) return error_text("Date Harus Diisi !", "custom");
    //     if (!s_cavity) return error_text("Cavity Harus Diisi !", "custom");

    //     window.open(
    //         url_api + 'production/tageto-report/export-excel' +
    //         '?s_start_date=' + encodeURIComponent(s_start_date) +
    //         '&s_end_date=' + encodeURIComponent(s_end_date) +
    //         '&s_model=' + encodeURIComponent(s_model || '') +
    //         '&s_cavity=' + encodeURIComponent(s_cavity || '') +
    //         '&s_shift=' + encodeURIComponent(s_shift || '')
    //     );
    // }


    // ===== Export Excel (butuh cavity) =====
    function export_excel() {
        const s_model = $('#s_model').val();
        const s_start_date = $('#s_start_date').val();
        const s_end_date = $('#s_end_date').val();
        const s_shift = $('#s_shift').val();
        const s_cavity = $('#s_cavity').val();

        if (!s_start_date) return error_text("Date Harus Diisi !", "custom");
        if (!s_end_date) return error_text("Date Harus Diisi !", "custom");
        // if (!s_cavity) return error_text("Cavity Harus Diisi !", "custom");

        const url =
            url_api + 'production/tageto-report/export-excel' +
            '?s_start_date=' + encodeURIComponent(s_start_date) +
            '&s_end_date=' + encodeURIComponent(s_end_date) +
            '&s_model=' + encodeURIComponent(s_model || '') +
            '&s_cavity=' + encodeURIComponent(s_cavity || '') +
            '&s_shift=' + encodeURIComponent(s_shift || '');

        // buka di tab baru; kalau popup diblok, fallback redirect
        const win = window.open(url, '_blank');
        if (!win || win.closed || typeof win.closed === 'undefined') {
            window.location.href = url;
        }
    }
</script>