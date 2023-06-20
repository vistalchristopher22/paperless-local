$(document).ready(function () {
  let breadCrumbTrack = ['Home'];
  let currentPath = "C:\laragon\www\paperless\storage\app\source";
  let directoriesTrack = [currentPath];

  loadFilesAndDirectories(currentPath);

  $('#breadcrumb').on('click', 'a', function (e) {
    e.preventDefault();
    let path = $(this).data('path');
    loadFilesAndDirectories(path);
  });

  $('#directories').on('dblclick', '.col[data-path]', function (e) {
    e.preventDefault();
    var path = $(this).data('path');
    loadFilesAndDirectories(path);
  });

  function loadFilesAndDirectories(path) {
    $('#files').html('');
    $('#directories').html(
      '<div class="text-center"><div class="spinner-border spinner-border-custom-2 text-primary" role="status"></div></div>'
    );

    $.ajax({
      url: '/admin/archive/files/get-files',
      type: 'GET',
      data: {
        path: path
      },
      success: function (data) {
        if (path !== currentPath) {
          // Check if the current directory is already in the breadcrumb track
          var breadcrumbIndex = breadCrumbTrack.indexOf(data.currentDirectory);
          if (breadcrumbIndex === -1) {
            // Add a new breadcrumb and directory path to the end of the arrays
            breadCrumbTrack.push(data.currentDirectory);
            directoriesTrack.push(data.path);
          } else {
            // Remove all breadcrumbs and directory paths after the current one
            breadCrumbTrack.splice(breadcrumbIndex + 1);
            directoriesTrack.splice(breadcrumbIndex + 1);
          }

          // Update the breadcrumb navigation
          updateBreadcrumbNavigation();
        } else {
          // Reset the breadcrumb navigation to the home folder
          breadCrumbTrack = ['Home'];
          directoriesTrack = [currentPath];
          updateBreadcrumbNavigation();
        }

        // Update the folder and file listings
        updateDirectoryListing(data.directories);
        updateFileListing(data.files);
      },
      error: function () {
        $('#directories').html(
          '<p class="text-center text-danger">There was an error loading the directories. Please try again.</p>'
        );
        $('#files').html(
          '<p class="text-center text-danger">There was an error loading the files. Please try again.</p>'
        );
      }
    });
  }

  function updateBreadcrumbNavigation() {
    // Clear the breadcrumb navigation
    $('#listBreadcrumb').empty();

    // Add each breadcrumb to the navigation
    for (var i = 0; i < breadCrumbTrack.length; i++) {
      var name = breadCrumbTrack[i];
      var path = directoriesTrack[i];
      var $breadcrumbLink = $('<a>').addClass('breadcrumb-link')
        .attr('data-path', path)
        .text(name);
      var $listItem = $('<li>').addClass('breadcrumb-item cursor-pointer')
        .append($breadcrumbLink);
      $('#listBreadcrumb').append($listItem);
    }
  }

  function updateDirectoryListing(directories) {
    var $directoryRow = $('<div>').addClass('row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
    for (var i = 0; i < directories.length; i++) {
      var directory = directories[i];
      var numFiles = directory.files.length;
      var numFolders = directory.directories.length;
      var fileStr = numFiles == 1 ? 'file' : 'files';
      var folderStr = numFolders == 1 ? 'folder' : 'folders';
      if (numFiles > 0 || numFolders > 0) {
        var $col = $('<div>').addClass('col mb-3 mb-lg-5')
          .attr('data-path', directory.path);
        var $card = $('<div>').addClass('card card-sm card-hover-shadow card-header-borderless h-100 text-center cursor-pointer');
        var $cardBody = $('<div>').addClass('card-body bg-light d-flex flex-column align-items-center justify-content-center');
        var $img = $('<img>').addClass('img-fluid w-25').attr('src', '/assets-2/images/widgets/folder-icon.svg').attr('alt', 'Folder Icon');
        var $details = $('<div>').addClass('mt-3');
        var $title = $('<h6>').addClass('').text(directory.basename);
        var $date = $('<p>').addClass('small').text('Last Modified: ' + new Date(directory.mTime * 1000).toLocaleString());
        var $count = $('<p>').addClass('small').text(numFiles + ' ' + fileStr + ', ' + numFolders + ' ' + folderStr);
        $details.append($title, $date, $count);
        $cardBody.append($img, $details);
        $card.append($cardBody);
        $col.append($card);
        $directoryRow.append($col);
      }
    }
    $('#directories').html($directoryRow);
  }

  function updateFileListing(files) {
    var $fileRow = $('<div>').addClass('row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5');
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var $col = $('<div>').addClass('col mb-3 mb-lg-5');
      var $card = $('<div>').addClass('card card-sm card-hover-shadow card-header-borderless h-100 text-center');
      var $cardBody = $('<div>').addClass('card-body bg-light d-flex flex-column align-items-center justify-content-center');
      var $img = $('<img>').addClass('img-fluid w-25').attr('src', '/assets-2/images/widgets/file-icon.svg').attr('alt', 'File Icon');
      var $details = $('<div>').addClass('mt-3');
      var $title = $('<h6>').addClass('').text(file.basename);
      var $date = $('<p>').addClass('small').text('Last Modified: ' + new Date(file.mTime * 1000).toLocaleString());
      var $link = $('<a>').addClass('small').attr('href', '/admin/archive/files/download?file=' + file.path).text('Download');
      $details.append($title, $date, $link);
      $cardBody.append($img, $details);
      $card.append($cardBody);
      $col.append($card);
      $fileRow.append($col);
    }
    $('#files').html($fileRow);
  }
});