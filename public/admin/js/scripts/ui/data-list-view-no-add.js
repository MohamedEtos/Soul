/*=========================================================================================
    File Name: data-list-view.js
    Description: List View
==========================================================================================*/

$(document).ready(function () {
  "use strict";

  // ================= List View =================
  var dataListView = $(".data-list-view").DataTable({
    responsive: false,
    columnDefs: [
      {
        orderable: true,
        targets: 0,
        checkboxes: { selectRow: true }
      }
    ],
    dom:
      '<"top"<"actions action-btns"><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
    oLanguage: {
      sLengthMenu: "_MENU_",
      sSearch: ""
    },
    aLengthMenu: [[4, 10, 15, 100 , 1000], [4, 10, 15, 100 , 1000]],
    select: {
      style: "multi"
    },
    order: [[1, "desc"]],
    bInfo: false,
    pageLength: 10,
    initComplete: function () {
      $(".dt-buttons .btn").removeClass("btn-secondary");
    }
  });

  dataListView.on("draw.dt", function () {
    setTimeout(function () {
      if (navigator.userAgent.indexOf("Mac OS X") != -1) {
        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox");
      }
    }, 50);
  });

  // ================= Thumb View =================
  var dataThumbView = $(".data-thumb-view").DataTable({
    responsive: false,
    columnDefs: [
      {
        orderable: true,
        targets: 0,
        checkboxes: { selectRow: f }
      }
    ],
    dom:
      '<"top"<"actions action-btns"><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
    oLanguage: {
      sLengthMenu: "_MENU_",
      sSearch: ""
    },
    aLengthMenu: [[4, 10, 15, 20,100], [4, 10, 15, 20, 100]],
    select: {
      style: "multi"
    },
    order: [[1, "desc"]],
    bInfo: false,
    pageLength: 10,
    initComplete: function () {
      $(".dt-buttons .btn").removeClass("btn-secondary");
    }
  });

  dataThumbView.on("draw.dt", function () {
    setTimeout(function () {
      if (navigator.userAgent.indexOf("Mac OS X") != -1) {
        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox");
      }
    }, 50);
  });

  // ================= Scrollbar =================
  if ($(".data-items").length > 0) {
    new PerfectScrollbar(".data-items", { wheelPropagation: false });
  }

  // ================= Close sidebar =================
  $(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on("click", function () {
    $(".add-new-data").removeClass("show");
    $(".overlay-bg").removeClass("show");
    $("#data-name, #data-price").val("");
    $("#data-category, #data-status").prop("selectedIndex", 0);
  });

  // ================= Edit =================
  $(".action-edit").on("click", function (e) {
    e.stopPropagation();
    $("#data-name").val("Altec Lansing - Bluetooth Speaker");
    $("#data-price").val("$99");
    $(".add-new-data").addClass("show");
    $(".overlay-bg").addClass("show");
  });

  // ================= Delete =================
  $(".action-delete").on("click", function (e) {
    e.stopPropagation();
    $(this).closest("tr").fadeOut();
  });

  // ================= Dropzone =================
  Dropzone.options.dataListUpload = {
    complete: function () {
      $(".hide-data-sidebar, .cancel-data-btn, .actions .dt-buttons").on(
        "click",
        function () {
          $(".dropzone")[0].dropzone.files.forEach(function (file) {
            file.previewElement.remove();
          });
          $(".dropzone").removeClass("dz-started");
        }
      );
    }
  };
  Dropzone.options.dataListUpload.complete();

  // ================= Mac checkbox fix =================
  if (navigator.userAgent.indexOf("Mac OS X") != -1) {
    $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox");
  }
});
