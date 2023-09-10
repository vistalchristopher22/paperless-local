@extends('layouts.app-2')
@section('tab-title', 'Back Tracking')
@prepend('page-css')
    <style>
        .order-of-business-content {
            white-space: pre-wrap;
        }

        .skeleton-9w80ug4gc2f:empty {
            height: 170px;
            background-color: #E1E1E1;
            border-radius: 0px 0px 0px 0px;
            background-image: linear-gradient(100deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0) 80%), linear-gradient(#cccccc 20px, transparent 0), radial-gradient(circle 14px at 14px 14px, #cccccc 13px, transparent 14px), linear-gradient(#cccccc 20px, transparent 0), radial-gradient(circle 14px at 14px 14px, #cccccc 13px, transparent 14px), linear-gradient(#cccccc 20px, transparent 0), radial-gradient(circle 14px at 14px 14px, #cccccc 13px, transparent 14px);
            background-repeat: repeat-y;
            background-size: 50px 170px, 300px 170px, 28px 170px, 300px 170px, 28px 170px, 300px 170px, 28px 170px;
            background-position: -20% 0, left 70px top 125px, left 20px top 120px, left 70px top 75px, left 20px top 70px, left 70px top 25px, left 20px top 20px;
            animation: shineForSkeleton-9w80ug4gc2f 3s infinite;
        }

        @keyframes shineForSkeleton-9w80ug4gc2f {
            to {
                background-position: 120% 0, left 70px top 125px, left 20px top 120px, left 70px top 75px, left 20px top 70px, left 70px top 25px, left 20px top 20px;
            }
        }
    </style>
@endprepend
@section('content')
    <div class="modal fade" tabindex="-1" id="previewModal">
        <div class="modal-dialog modal-xl modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title card-title h6">Preview Document</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 m-0" style="overflow-y: hidden">
                    <iframe src="" id="previewIframe" width="100%" height="110%"
                        style="position:absolute; top :0%;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-light p-5">
        <div class="container">
            <div class="text-center mb-3">
                <span class="fw-bolder h1" id="title">S E A R C H</span>
            </div>
            <input type="text" id="search" class="form-control form-control-lg p-3"
                placeholder="Type something">
        </div>
    </div>

    <div class="p-3" id="results">

    </div>

    @push('page-scripts')
        <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
        <script>

            var typed = new Typed('#title', {
                strings: ['<span class="fw-bolder">S E A R C H</span>', '<span class="fw-bolder">O R D I N A N C E</span>', '<span class="fw-bolder">C O N T E N T</span>', '<span class="fw-bolder">TYPE SOMETHING</span>', '<span class="fw-bolder">EXAMPLE : LOCAL GOVERNMENT UNIT</span>', '<span class="fw-bolder">EXAMPLE : ORDER OF BUSINESS 49TH</span>',],
                typeSpeed: 100,
            });

            $('#search').keyup(function(e) {
                if (e.keyCode == 13) {
                    let searchKey = $(this).val();
                    if (searchKey !== "") {
                        $('#results').empty();
                        $('#results').append(`
                            <div id="spinner ">
                                <center>
                                    <div class="skeleton-9w80ug4gc2f mb-3"></div>
                                    <div class="skeleton-9w80ug4gc2f mb-3"></div>
                                    <div class="skeleton-9w80ug4gc2f mb-3"></div>
                                    <div class="skeleton-9w80ug4gc2f mb-3"></div>
                                </center>
                            </div>
                        `);

                        $.ajax({
                            url: 'http://192.168.1.33:3030/api/order-business-content/search',
                            method: 'POST',
                            data: {
                                key: searchKey,
                            },
                            success: function(response) {
                                if (response.data.length !== 0) {
                                    $('#results').empty();
                                    $('#results').append(
                                        `<span class="fs-5"><b>${response.data.length}</b> results found for <b>${searchKey}</b> <strong>${response.currentPage}</strong> of <strong>${response.totalPages}</strong></span>`
                                    );

                                    response.data.forEach(orderOfbusiness => {
                                        orderOfbusiness.content = orderOfbusiness.content.replace(
                                            /\n{4,}/g, '\n');
                                        $('#results').append(`
                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-header bg-dark">
                                                    <div class="card-title h6 text-white text-uppercase d-flex justify-content-between align-items-center">
                                                        <div>
                                                            ${orderOfbusiness.title}
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-light btn-view-file" data-url="${orderOfbusiness.file_path_view}">View File</button>
                                                            <button class="btn btn-sm btn-light btn-show-explorer ms-2" data-file="${orderOfbusiness.file_path}">Show in Explorer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body order-of-business-content fs-4 mb-0">
                                                        ${highlightAndDisplayWords(orderOfbusiness.content, searchKey, 100)}
                                                </div>
                                            </div>
                                        `);
                                    });
                                } else {
                                    $('#results').empty();
                                    $('#results').append(`
                                        <div class="fs-3 text-center text-danger align-middle">
                                            <i class="mdi mdi-emoticon-sad mx-2"></i>No available results
                                        </div>
                                   `);
                                }

                                $('#spinner').addClass('d-none');
                            },
                            error: function() {
                                $('#spinner').addClass('d-none');
                            }
                        });
                    } else {
                        $("#results").empty();
                    }
                }
            });

            function highlightAndDisplayWords(longText, searchTerm, wordsAround) {
                const searchTermLower = searchTerm.toLowerCase();
                const searchTermUpper = searchTerm.toUpperCase();
                const searchTermCapitalized =
                    searchTermLower.charAt(0).toUpperCase() + searchTermLower.slice(1);

                const textLower = longText.toLowerCase();
                const textUpper = longText.toUpperCase();

                let startIndex = textLower.indexOf(searchTermLower);
                let endIndex = textLower.lastIndexOf(searchTermLower) + searchTermLower.length;

                // If the searchTerm is not found, return the original longText
                if (startIndex === -1) {
                    return longText;
                }

                // Extract the highlighted section of the longText within the specified wordsAround range
                const highlighted = longText.substring(
                    Math.max(0, startIndex - wordsAround),
                    Math.min(endIndex + wordsAround, longText.length)
                );

                // Add ellipses if the extracted section does not start or end at the beginning or end of the longText
                const highlightedWithEllipses =
                    (startIndex - wordsAround > 0 ? '... ' : '') +
                    highlighted +
                    (endIndex + wordsAround < longText.length ? ' ...' : '');

                // Replace all occurrences of the searchTerm with the highlighted version
                const finalResult = highlightedWithEllipses
                    .replace(new RegExp(searchTermLower, 'gi'), '<mark><strong>$&</strong></mark>')
                    .replace(new RegExp(searchTermUpper, 'g'), '<mark><strong>$&</strong></mark>')
                    .replace(new RegExp(searchTermCapitalized, 'g'), '<mark><strong>$&</strong></mark>');

                return finalResult;
            }

            function searchInIframe(iframe, searchTerm) {
                const iframeWindow = iframe.contentWindow;
                const iframeDocument = iframeWindow.document;

                if (iframeWindow.find && iframeWindow.getSelection) {
                    iframeDocument.designMode = 'on';

                    const sel = iframeWindow.getSelection();
                    sel.collapse(iframeDocument.body, 0);

                    while (iframeWindow.find(searchTerm)) {
                        iframeDocument.execCommand('HiliteColor', false, 'yellow');
                        sel.collapseToEnd();
                    }

                    iframeDocument.designMode = 'off';
                }
            }



            $(document).on('click', '.btn-view-file', function() {
                let url = $(this).attr('data-url');
                let iframeUrl = `${url}#zoom=190&toolbar=0`;
                let searchTermWord = $('#search').val();

                const tempTextarea = document.createElement('textarea');
                tempTextarea.value = searchTermWord;
                document.body.appendChild(tempTextarea);

                tempTextarea.select();
                tempTextarea.setSelectionRange(0, searchTermWord.length);

                document.execCommand('copy');

                document.body.removeChild(tempTextarea);
                $('#previewModal').find('iframe').attr('src', iframeUrl);
                $('#previewModal').modal('show');
            });

            $(document).on('click', '.btn-show-explorer', function() {
                let filePath = $(this).attr('data-file');

                $.ajax({
                    url : '/backtracking/show-explorer',
                    method : 'POST',
                    data : {
                        path : filePath,
                    },
                    success : function (response) {

                    }
                });
            });
        </script>
    @endpush
@endsection
