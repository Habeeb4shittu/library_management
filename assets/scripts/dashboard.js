$(document).ready(function () {
    let date = new Date();
    let greet = ''
    if (date.getHours() > 0 && date.getHours() < 12) {
        greet = '<span> Morning</span>'
        $(greet).insertAfter("span.good-d")
    } else if (date.getHours() >= 12 && date.getHours() < 17) {
        greet = '<span> Afternoon</span>'
        $(greet).insertAfter("span.good-d")
    } else {
        greet = '<span> Evening</span>'
        $(greet).insertAfter("span.good-d")
    }
    $("#cat-table").DataTable()
});
let data = [{
        label: "Published Books",
        value: $(".book-count").text()
    }, {
        label: "Categories",
        value: $(".category-count").text()
    },
    {
        label: "Views",
        value: $(".view-count").text()
    },
    {
        label: "Likes",
        value: $(".like-count").text()
    },
    {
        label: "Downloads",
        value: $(".download-count").text()
    }
]
let labels = data.map(i => i.label)
let values = data.map(i => i.value)
let trace = {
    x: labels,
    y: values,
    type: 'trace'
}
let Layout = {
    title: "Insights",
    xaxis: {
        title: 'Metrics'
    },
    yaxis: {
        title: "Count"
    }
}
$(".count").each(function (i, el) {
    let prev = $(this).text()
    let count = 0
    let rush = setInterval(() => {
        count++
        if (count == prev) {
            clearInterval(rush)
        }
        if (prev != 0) {
            $(this).text(count)
        }
    }, 90);
})
$(".cover").click(function () {
    this.requestFullscreen()
})
$("#cover").on('input', function () {
    // console.log($(this)[0].files[0]);
    const imageSrc = URL.createObjectURL($(this)[0].files[0]);
    if ($(this)[0].files[0].type !== "image/jpeg" &&
        $(this)[0].files[0].type !== "image/jpg" &&
        $(this)[0].files[0].type !== "image/png") {
        return
    } else {
        $(".chooser img").attr({
            src: imageSrc
        })
    }
    console.log(imageSrc);
})
$("#bookChooser").on('input', function () {
    $(".book-chooser").text($(this)[0].files[0].name)
})
$(".category-card").click(function () {
    location.href = location.origin + `/admin/manage-category.php`
})
$(".book-card").click(function () {
    location.href = location.origin + `/admin/manage-book.php`
})
$(".edit").click(function () {
    let id = $(this).data('id');
    $.post("../../src/request.php", {
            category_id: id
        }, null, "json")
        .done(function (res) {
            $("#editCategoryInp").val(res[0].category)
            $("#editCategoryInp").attr('data-id', res[0].id)
        })
})
$(".edit-book").click(function () {
    let id = $(this).data('id');
    $.post("../../src/request.php", {
            book_id: id
        }, null, "json")
        .done(function (res) {
            $("#editBookInp").val(res[0].name)
            $("#editBookInp").attr('data-id', res[0].id)
            $.post("../../src/request.php", {
                    category_id: res[0].category_id
                }, null, "json")
                .done(function (res) {
                    $("select option").each(function (i, el) {
                        if ($(el).text().includes(res[0].category)) {
                            $(this).prop({
                                selected: true
                            })
                        }
                    })
                })
        })
})
$(".delete").click(function () {
    let id = $(this).data('id');
    $(".confirm-delete").attr('data-id', id)
})
$(".book-delete").click(function () {
    let id = $(this).data('id');
    $(".confirm-book-delete").attr('data-id', id)
})
$(".confirm-delete").click(function () {
    let deleteCat = $(this).data('id')
    $.post("../../src/request.php", {
            delete: deleteCat
        }, null, "json")
        .done(function (res) {
            if (res) {
                location.reload()
            }
        })
})
$(".confirm-book-delete").click(function () {
    let deleteBook = $(this).data('id')
    $.post("../../src/request.php", {
            deleteBook: deleteBook
        }, null, "json")
        .done(function (res) {
            if (res) {
                location.reload()
            }
        })
})
$("#eCategory").on('submit', function (e) {
    e.preventDefault()
    let category = $("#editCategoryInp").val()
    let id = $("#editCategoryInp").data('id')
    $.post("../../src/request.php", {
            new_category: category,
            id
        }, null, "json")
        .done(function (res) {
            $("#eCategory").find('.alert').remove()
            if (res.error) {
                $("#eCategory").prepend(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${res.error}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
            } else {
                $("#eCategory").prepend(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${res.success}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
            }
            setTimeout(() => {
                $("#eCategory").find('.alert').remove()
                location.reload()
            }, 1500);
        })
})
Plotly.newPlot('chart', [trace], Layout)