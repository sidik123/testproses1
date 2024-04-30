<?php
include("../fungsi/koneksi.php");
?>

<style>
    ion-icon {
        font-size: 34px;
    }

    .formtable {
        padding: 0;
        display: block;
    }

    /* Gaya untuk tabel responsif */
    .table-responsive {
        overflow-x: auto;
    }

    .table-responsive table {
        border: 1px solid black;
    }

    /* Gaya untuk sel header dengan class "table-info" */
    .table #info {
        text-align: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
    }

    /* Gaya untuk checkbox-container */
    .checkbox-container {
        align-items: center;
        margin-top: -5px;
        margin-bottom: -5px;
        font-size: 12px;
        font-weight: bold;
    }

    .table-primary th {
        color: #333;
        text-align: center;
        margin-bottom: 0px;
        font-size: 15px;
    }

    .monitor {
        text-align: center;
        justify-content: center;
        margin: 0px;
        padding: 0px;
    }

    #dataContainer {
        color: #333;
        text-align: center;
        margin-bottom: 0px;
        font-size: 13px;
    }

    #dataContainer tr {
        border-bottom: 1px solid black;
        padding: 0px;
        margin: 0px;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 15px;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
            border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
        margin-right: 10px;
        width: 100px;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        width: 100px;
    }

    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    #infoTable th {
        padding-top: 1px;
        font-size: 12px;
        position: relative;
        text-align: center;
        justify-content: center;
        padding-bottom: -2px;
    }

    @media (max-width: 1091px) {

        .btn-success,
        .btn-danger {
            margin-top: 5px;
        }

        .btn-danger {
            margin-top: 5px;
            margin-right: 10px;
        }

        .btn-secondary {
            margin-top: 25px;
        }
    }

    @media (max-width: 440px) {
        .select-all {
            font-size: 9px;
        }

        .btn-secondary {
            margin-top: 25px;
        }
    }
</style>

    <?php include("header.php") ?>
    
<div class="container-fluid">

    <div class="row pt-2 pb-2">
        <div class="col-sm-9 mt-5">
            <h4 class="page-title">Website Management System</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Web Setting</li>
            </ol>
        </div>

        <div class="col-lg-12">

            <div class="tab-content">
                <div class="tab-pane active" id="web_setting_default_content" role="tabpanel"
                    aria-labelledby="home-tab">
                    <table id="default-datatable" class="table-bordered table border-top">
                        <thead>
                            <tr>
                            <td colspan="3" class="card-header padding-5 uppercase text-center" style="background-color: black; color: white;">Header Setting</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Website Title</td>
                                <td>
                                    <input type="text" class="form-control defaultInput" id="WebTitle"value="<?php echo $websiteTitle ?>"disabled="disabled" required=""></td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Meta Description</td>
                                <td>
                                    <input type="text" class="form-control defaultInput" id="MetaDescription"value="<?php echo $websiteDescription ?>"disabled="disabled" required=""></td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Meta Keyword</td>
                                <td>
                                    <input type="text" class="form-control defaultInput" id="MetaKeyword" value="<?php echo $websiteKeyword ?>"disabled="disabled" required=""></td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Meta Header</td>
                                <td>
                                    <textarea rows="5" class="form-control defaultInput" id="MetaHeaderWeb"disabled="disabled"required=""><?php echo $websiteMetaHeaderWeb ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Google Analytic</td>
                                <td>
                                    <input type="text" class="form-control defaultInput" id="GoogleAnalytic" value="<?php echo $GoogleAnalytic ?>" disabled="disabled" required=""></td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="default-datatable" class="table-bordered table border-top">
                        <thead>
                            <tr>
                                <td colspan="3" class="card-header padding-5 uppercase text-center" style="background-color: black; color: white;">Web Content</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Running Text</td>
                                <td>
                                    <input type="text" class="form-control defaultInput" id="RunningText" value="<?php echo $Marquee ?>" disabled="disabled" required=""></td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">Footer</td>
                                <td>
                                    <textarea rows="5" class="form-control defaultInput" id="Footer" disabled="disabled" required=""><?php echo $websiteFooterWebsite ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">LiveChat Desktop</td>
                                <td>
                                    <textarea rows="5" class="form-control defaultInput" id="LiveChatDesktop" disabled="disabled" required=""><?php echo $LiveChatDesktop ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px form-caption defaultSet">LiveChat Mobile</td>
                                <td>
                                    <textarea rows="5" class="form-control defaultInput" id="LiveChatMobile" disabled="disabled" required=""><?php echo $LiveChatMobile ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td scope="col" class="uppercase font-bold max-width-170px font-size-10px border-none"></td>
                                <td class="border-none">
                                    <button type="button" id="websettingeditDefault" class="btn btn-primary btn-lg waves-effect waves-light float-right">
                                    <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="submit" id="websettingsaveDefault" class="btn btn-primary btn-lg waves-effect waves-light float-right" hidden="true">
                                    <i class="fas fa-save"></i> Save
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- end of the row -->

    <script>
    document.getElementById('websettingsaveDefault').addEventListener('click', function() {
        // Ambil nilai dari input dan textarea
        var websiteTitle = document.getElementById('WebTitle').value;
        var metaDescription = document.getElementById('MetaDescription').value;
        var metaKeyword = document.getElementById('MetaKeyword').value;
        var MetaHeaderWeb = document.getElementById('MetaHeaderWeb').value;
        var googleAnalytic = document.getElementById('GoogleAnalytic').value;
        var runningText = document.getElementById('RunningText').value;
        var footer = document.getElementById('Footer').value;
        var liveChatDesktop = document.getElementById('LiveChatDesktop').value;
        var liveChatMobile = document.getElementById('LiveChatMobile').value;

        // Kirim data ke server menggunakan AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../admin_realtime/websetting_edit.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Berhasil menyimpan data
                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function(){
                    // Alihkan pengguna ke halaman web_setting.php
                    window.location.href = "<?php echo $alamat_websitePanel; ?>/admin/web_setting.php";
                });
            }
        };
        // Membuat string data yang akan dikirim dalam format yang sesuai dengan form URL encoded
        var data = 'websiteTitle=' + encodeURIComponent(websiteTitle) +
                   '&metaDescription=' + encodeURIComponent(metaDescription) +
                   '&metaKeyword=' + encodeURIComponent(metaKeyword) +
                   '&MetaHeaderWeb=' + encodeURIComponent(MetaHeaderWeb) +
                   '&googleAnalytic=' + encodeURIComponent(googleAnalytic) +
                   '&runningText=' + encodeURIComponent(runningText) +
                   '&footer=' + encodeURIComponent(footer) +
                   '&liveChatDesktop=' + encodeURIComponent(liveChatDesktop) +
                   '&liveChatMobile=' + encodeURIComponent(liveChatMobile);
        xhr.send(data);
    });
</script>


    <script type="text/javascript">
        $(document).ready(function () {
            $("#dialog-mask").show();
            getDefaultList();
        });
        $("#websettingsaveDefault").click(function () {
            $("#dialog-mask").show();
            $('#websettingeditDefault').attr("hidden", false);
            $('#websettingsaveDefault').attr("hidden", true);
            //setDefaultEdit();
            setDataDefaultChange();
        });

        $("#websettingsaveDomain").click(function () {
            $('#websettingeditDomain').attr("hidden", false);
            $('#websettingsaveDomain').attr("hidden", true);
            //setDomainEdit();
            setDataSeoDomainChange();
        });
        $("#websettingeditDomain").click(function () {
            $('#isDefault').attr("checked", false);
            $('#websettingeditDomain').attr("hidden", true);
            $('#websettingsaveDomain').attr("hidden", false);
            $('.domainInput').prop('disabled', false);
        });
        $("#websettingeditDefault").click(function () {
            $('#websettingeditDefault').attr("hidden", true);
            $('#websettingsaveDefault').attr("hidden", false);
            $('.defaultInput').prop('disabled', false);
        });

        $("#basic-select-sedm").on("change", function () {
            $('#isDefault').attr("checked", false);
            if ($(this).val() != -1) {
                $('#websettingeditDomain').attr("hidden", false);
                $('#websettingsaveDomain').attr("hidden", true);
                $('.domainInput').prop('disabled', true);
                getDomainList();
            }
        });
    </script>

<?php include("footer.php"); ?>