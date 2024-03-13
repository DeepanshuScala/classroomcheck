@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Store Dashboard Section SALE REPORT PRODUCTS Starts Here-->
    <section class="help-faq-section sales-report-section store-dashboard-report ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-lg-8">
                    <h1 class="text-uppercase"> Reports</h1>
                </div>
                <div class="col-12 col-sm-12 col-lg-4 pt-5">
                    <div class="text-end pb-5">
                        <a href="{{route('storeDashboard.reports')}}" class="blue acc-dashboard"><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt="">Reports</a>
                    </div>
                </div>

            </div>
            <div class="row row-cols-5 col-12 row-cols-sm-12 row-cols-md-3 row-cols-lg-3 row-cols-xl-5 gx-3 gx-sm-4">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.salesReport')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon-box_1 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-1.png')}}" class="img-fluid " alt="report-icon-1 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.SalesByCountry')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_2 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-2.png')}}" class="img-fluid " alt="report-icon-2 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales by Country </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.salesTax')}}">
                        <div class="card card-box border-0 text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_3 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-3.png')}}" class="img-fluid " alt="report-icon-3 ">
                                </div>
                                <h4 class="pt-3 mb-2 fw-bold ">Sales Tax</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.products')}}">
                        <div class="card card-box border-0  text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_4 rounded-circle text-center mx-auto py-5 ">
                                    <img src="{{asset('images/report-icon-4.png')}}" class="img-fluid " alt="report-icon-4 ">
                                </div>
                               <h4 class="pt-3 mb-2 fw-bold ">Products </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">
                    <a href="{{route('storeDashboard.reports.marketing')}}">
                        <div class="card card-box highlight-red text-center h-100 py-4 ">
                            <div class="card-body das-card">
                                <div class="icon-box icon_bg_5 rounded-circle text-center mx-auto py-5 ">
                                    <img src="images/report-icon-5.png " class="img-fluid " alt="report-icon-5 ">
                                </div>
                               <h4 class="pt-3 mb-2 fw-bold ">Marketing</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row py-5">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="text-uppercase">Marketing</h1>
                </div>
            </div>

            <div class="row align-items-center pb-4">
                <form method="get" name="sale_filter">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 d-flex flex-row align-items-center">
                            <div class="date-picker pb-3">
                                <label for="start" class="pe-3 date-range">Date Range</label>
                                <input type="date" name="start_date" class="bg-light border-0 text-muted ps-2" id="start" value="{{isset($_GET['start_date'])?$_GET['start_date']:''}}" min="2018-01-01" max="">
                                <label for="To" class="px-4 to">To</label>
                                <input type="date" name="end_date" class="bg-light border-0 text-muted ps-2" id="end" name="end_date" value="{{isset($_GET['end_date'])?$_GET['end_date']:''}}" min="2018-01-01" max="">
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 d-flex flex-row align-items-center sales-by-country-left">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="search my-purchase-history"> 
                                        <input type="text" name="productname" class="form-control" placeholder="Search by Product name" value="{{isset($_GET['productname'])?$_GET['productname']:''}}"> 
                                        <!-- <button class="btn-hover">
                                            <i class="fa fa-search"></i>
                                        </button> -->
                                    </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex flex-row align-items-end justify-content-end sales-by-country-right">
                                <input type="submit" class="btn btn-hover btn-lg px-5 apply-btn" value="Apply">
                                <?php
                                if( (isset($_GET['start_date']) && !empty($_GET['start_date'])) || (isset($_GET['end_date']) && !empty($_GET['end_date'])) || (isset($_GET['productname']) && !empty($_GET['productname']))  ){
                                ?>
                                    <a href="{{url()->current()}}" class="btn btn-hover btn-lg px-3 ms-2">Reset Filters</a>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div class="row align-items-center pb-4">
                <div class="col-12 col-sm-12 col-md-6 col-lg-8 d-flex flex-row align-items-center sales-details">
                    <div class="total-sale-period col-6 col-sm-6 col-md-6 col-lg-6">
                        <p class="fw-bold">Total Sales for Period:<span class="text-muted px-3 fw-normal">$ {{number_format((float)$data['total_sale_for_period'], 2, '.', '')}} </span></p>
                    </div>
                    <div class="total-earnings-period col-6 col-sm-6 col-md-6 col-lg-6">
                        <p class="fw-bold">Total Earnings for Period:<span class="text-muted px-3 fw-normal">$ {{number_format((float)$data['total_earnings_for_period'], 2, '.', '')}}</span></p>
                    </div>
                </div>
                <div class="col-6 col-sm-12 col-md-6 col-lg-4 d-flex flex-row align-items-center justify-content-end">
                    @if(count($data['sales']) > 0)
                        <select class="form-select sort-filter border-0 text-dark px-2 fw-boldQ" name="download-report" id="download-report" aria-label="Default select example" style="width:175px;">
                            <option value="" selected="" disabled="">Download Report</option>
                            <option value="pdf">pdf</option>
                            <option value="xls">xls</option>
                            <option value="csv">csv</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="row py-5">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 sales-report-data ">
                    <h5 class="bg-blue text-uppercase text-center text-white p-3"> Sales Report By Marketing </h5>
                    <div class="table-responsive">
                        <table class="table sales-report-data-products" id="fixed_table">
                            <thead>
                                <tr>
                                    <th scope="col">Feature Dates</th>
                                    <th scope="col">Product title</th>
                                    <th scope="col">Product Code</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Single<br> License Price</th>
                                    <th scope="col">Multiple<br>License Price</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Sales Tax</th>
                                    <th scope="col">Sale Commision</th>
                                    <th scope="col">Transaction Charge</th>
                                    <th scope="col">Earning<span class="period">(for period)</span> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($data['sales']) > 0){
                                    foreach($data['sales'] as $key => $pr){
                                    ?>
                                    <tr class="bg-success bg-opacity-5">
                                        <th scope="row">{{$pr['dates']}}</th>
                                        <td>{{$pr['product_name']}}</td>
                                        <td>{{$pr['product_code']}}</td>
                                        <td>{{$pr['numberofsales']}}</td>
                                        <td>{{number_format((float)$pr['single_price'], 2, '.', '')}}</td>
                                        <td>{{number_format((float)$pr['multiple_price'], 2, '.', '')}}</td>
                                        <td>{{number_format((float)$pr['amount'], 2, '.', '')}}</td>
                                        <td>{{number_format((float)$pr['sale_tax'], 2, '.', '')}}</td>
                                        <td>{{number_format((float)$pr['sale_commision'], 2, '.', '')}}</td>
                                        <td>{{number_format((float)$pr['transaction_charge'], 2, '.', '')}}</td>
                                        <td>${{number_format((float)$pr['total_earnings'], 2, '.', '')}}</td>
                                    </tr>
                                    <?php 
                                    }
                                }
                                else{
                                    ?>
                                    <tr>
                                        <td colspan="11"><p class="w-auto m-auto btn btn-hover btn-lg px-3 ">No data found</p></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                /*
                                    <tr>
                                        <th scope="row">Language Posters</th>
                                        <td>13/03/22</td>
                                        <td>0</td>
                                        <td>23</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0%</td>
                                        <td>3</td>
                                        <td>0</td>
                                        <td>$ 2.60</td>
                                        <td align="center"><a href="#"><i class='fas fa-download fa-sm'></i><a></td>
                                    </tr>
                                    <tr class="bg-danger bg-opacity-5">
                                        <th scope="row">Mathematics Posters</th>
                                        <td>14/03/22</td>
                                        <td>0</td>
                                        <td>5</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0%</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>$ 0.70</td>
                                        <td align="center"><a href="#"><i class='fas fa-download fa-sm'></i><a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Angle Posters</th>
                                        <td>15/03/22</td>
                                        <td>0</td>
                                        <td>14</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0%</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>$ 0.70</td>
                                        <td align="center"><a href="#"><i class='fas fa-download fa-sm'></i><a></td>
                                    </tr>
                                    <tr class="bg-primary bg-opacity-5">
                                        <th scope="row">3D Shape Posters</th>
                                        <td>16/03/22</td>
                                        <td>0</td>
                                        <td>3</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0%</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>$ 0.70</td>
                                        <td align="center"><a href="#"><i class='fas fa-download fa-sm'></i><a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Science Posters</th>
                                        <td>17/03/22</td>
                                        <td>0</td>
                                        <td>87</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>3%</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>$ 0.70</td>
                                        <td align="center"><a href="#"><i class='fas fa-download fa-sm'></i><a></td>
                                    </tr>
                                */
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
    </section>
    <!--<!--Store Dashboard Section SALE REPORT PRODUCTS  Ends Here-->
@endsection

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="{{asset('js/jspdf.js')}}"></script>
<script src="{{asset('js/FileSaver.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.table.js')}}"></script>
<script type="text/javascript">
    //window.jsPDF = window.jspdf.jsPDF;
    $(function () {
        $("#download-report").on('change', function (event) {
            // CSV
            event.preventDefault();
            if($(this).val() == 'pdf'){
                /*
                    html2canvas($('#fixed_table')[0], {
                        onrendered: function (canvas) {
                            var data = canvas.toDataURL();
                            var docDefinition = {
                                content: [{
                                    image: data,
                                    width: 500
                                }]
                            };
                            pdfMake.createPdf(docDefinition).download("seller.pdf");
                        }
                    });
                    
                     var table1 = 
                            tableToJson($('#fixed_table').get(0)),
                            cellWidth = 35,
                            rowCount = 0,
                            cellContents,
                            leftMargin = 2,
                            topMargin = 12,
                            topMarginTable = 55,
                            headerRowHeight = 13,
                            rowHeight = 9,

                             l = {
                                 orientation: 'l',
                                 unit: 'mm',
                                 format: 'a3',
                                 compress: true,
                                 fontSize: 8,
                                 lineHeight: 1,
                                 autoSize: false,
                                 printHeaders: true
                             };

                        var doc = new jsPDF(l, '', '', '');

                        doc.setProperties({
                            title: 'Sales Report',
                            subject: 'salesreport',
                            author: 'author',
                            keywords: 'generated, javascript, web 2.0, ajax',
                            creator: 'classroom copy'
                        });

                        doc.cellInitialize();
                        console.log(table1);
                       $.each(table1, function (i, row)
                        {

                            rowCount++;

                            $.each(row, function (j, cellContent) {

                                if (rowCount == 1) {
                                    doc.margins = 1;
                                    doc.setFont("helvetica");
                                    doc.setFontType("bold");
                                    doc.setFontSize(9);

                                    doc.cell(leftMargin, topMargin, cellWidth, headerRowHeight, cellContent, i)
                                }
                                else if (rowCount == 2) {
                                    doc.margins = 1;
                                    doc.setFont("times ");
                                    doc.setFontType("italic");  // or for normal font type use ------ doc.setFontType("normal");
                                    doc.setFontSize(8);                    

                                    doc.cell(leftMargin, topMargin, cellWidth, rowHeight, cellContent, i); 
                                }
                                else {

                                    doc.margins = 1;
                                    doc.setFont("courier ");
                                    doc.setFontType("bolditalic ");
                                    doc.setFontSize(6.5);                    

                                    doc.cell(leftMargin, topMargin, cellWidth, rowHeight, cellContent, i);  // 1st=left margin    2nd parameter=top margin,     3rd=row cell width      4th=Row height
                                }
                            })
                        })

                        doc.save('sample Report.pdf'); 
                */
                    generatefromtable();
                    
                    function generatefromtable() {
                        var data = [], fontSize = 12, height = 0, doc;
                        doc = new jsPDF('p', 'pt', 'a4', true);
                        doc.setFont("times", "normal");
                        doc.setFontSize(fontSize);
                        data = [];
                        data = doc.tableToJson('fixed_table');
                        height = doc.drawTable(data, {
                            left:10,
                            top:30,
                            bottom: 10,
                            width: 250,
                            rowHeight : 9,
                            
                        });
                        doc.save("sales-report.pdf");
                    } 
            }
            else if($(this).val() == 'csv'){
                tableToCSV();
            }
            else if( $(this).val() == 'xls' ){
                fnExcelReport();
            }
            
        });

        $("#start").on('change',function(e){
            $("#end").attr('min',$(this).val());
        })
        $(document).on('submit','form[name="sale_filter"]',function(e){ 
            
            var filterform = $("form[name='sale_filter']");
            var startdate = filterform.find("input[name='start_date']").val();
            var enddate = filterform.find("input[name='end_date']").val();
            var productname = filterform.find("input[name='productname']").val();

            if(productname == '' && startdate == ''){
                Swal.fire({
                    title: 'Oops!',
                    text: "Please select a date range or enter productname",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 2000,
                    //closeOnClickOutside: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                return false;
            }

            if(startdate !== '' && enddate == ''){
                Swal.fire({
                    title: 'Oops!',
                    text: "Please select end date",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 2000,
                    //closeOnClickOutside: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                return false;
            }
        });
    });
    
    
    function tableToJson(table) {
        var data = [];

        // first row needs to be headers
        var headers = [];
        for (var i=0; i<table.rows[0].cells.length; i++) {
            headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
        }
        console.log(headers)
        // go through cells
        for (var i=1; i<table.rows.length; i++) {

            var tableRow = table.rows[i];
            var rowData = {};

            for (var j=0; j<tableRow.cells.length; j++) {

                rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

            }

            data.push(rowData);
        }       

        return data; 
    }

    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#customers')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
        }, margins);
    }

    function tableToCSV() {
        // Variable to store the final csv data
        var csv_data = [];

        // Get each row data
        var rows = document.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {

            // Get each column data
            var cols = rows[i].querySelectorAll('td,th');

            // Stores each csv row data
            var csvrow = [];
            for (var j = 0; j < cols.length; j++) {

                // Get the text data of each cell
                // of a row and push it to csvrow
                function stripHtml(html)
                {
                   let tmp = document.createElement("DIV");
                   tmp.innerHTML = html;
                   return tmp.textContent || tmp.innerText || "";
                }
                html = stripHtml(cols[j].innerHTML);
                csvrow.push(html);
            }

            // Combine each column value with comma
            csv_data.push(csvrow.join(","));
        }

        // Combine each row data with new line character
        csv_data = csv_data.join('\n');

        // Call this function to download csv file 
        downloadCSVFile(csv_data);

    }

    function downloadCSVFile(csv_data) {

        // Create CSV file object and feed
        // our csv_data into it
        CSVFile = new Blob([csv_data], {
            type: "text/csv"
        });

        // Create to temporary link to initiate
        // download process
        var temp_link = document.createElement('a');

        // Download csv file
        temp_link.download = "salesreport.csv";
        var url = window.URL.createObjectURL(CSVFile);
        temp_link.href = url;

        // This link should not be displayed
        temp_link.style.display = "none";
        document.body.appendChild(temp_link);

        // Automatically click the link to
        // trigger download
        temp_link.click();
        document.body.removeChild(temp_link);
    }

    function fnExcelReport(){
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
        tab = document.getElementById('fixed_table'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++) 
        {     
            tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE "); 

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus(); 
            sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
        }  
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

        return (sa);
    }
</script>
@endpush