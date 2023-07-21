$(document).ready(function () {
    let date = new Date();
    let greet = ''
    if (date.getHours() > 0 && date.getHours() < 12) {
        greet = '<span> Morning</span>'
        $(greet).insertAfter("span.good")
    } else if (date.getHours() >= 12 && date.getHours() < 17) {
        greet = '<span> Afternoon</span>'
        $(greet).insertAfter("span.good")
    } else {
        greet = '<span> Evening</span>'
        $(greet).insertAfter("span.good")
    }
});
$(".bar").click(function () {
    $("nav ul").toggleClass('active')
    $(this).toggleClass('opened')
    if ($(this).hasClass('opened')) {
        $(this).empty().append(`
            <i class="fa fa-times" aria-hidden="true"></i>
        `)
    } else {
        $(this).empty().append(`
            <i class="fa fa-bars" aria-hidden="true"></i>
        `)
    }
})
$(".logo").click(function () {
    location.reload()
})
$(document).ready(function () {
    if (window.outerWidth > 720) {
        $(".link").removeClass("mobile").addClass("desktop")
    } else {
        $(".link").removeClass("desktop").addClass("mobile")
    }
    $(window).on('resize', function () {
        if (window.outerWidth > 720) {
            $(".link").removeClass("mobile").addClass("desktop")
        } else {
            $(".link").removeClass("desktop").addClass("mobile")
        }
    })
    $(".mobile").click(function () {
        $(this).siblings().find(".drop").removeClass('dropdown')
        $(this).find('.drop').toggleClass('dropdown')
    })

});
$(".show").click(function () {
    if ($(this).siblings("input").prop("type") == "password") {
        $(this).siblings("input").prop({
            type: "text"
        })
        $(this).empty().append(`
            <i class="fa fa-eye-slash" aria-hidden="true"></i>
        `)
    } else {
        $(this).siblings("input").prop({
            type: "password"
        })
        $(this).empty().append(`
            <i class="fa fa-eye" aria-hidden="true"></i>
        `)
    }
})
$("#searchBookModal").on('input', function () {
    let valu = $(this).val()
    $.post("../../src/request.php", {
            search: $(this).val()
        }, null, "JSON")
        .done(function (res) {
            // console.log(res);
            $("#booksInp").empty()
            $(res).each(function (i, el) {
                $("#booksInp").append(`
                        <option value="${el.name}" data-id="${el.id}" class="opt">
                `)
            })
        })
    $(".search-icon").click(function () {
        location.href = `${location.origin}/search.php?search=${valu}`
    })
    $(this).on('keydown', function (ev) {
        if (ev.key == "Enter") {
            location.href = `${location.origin}/search.php?search=${valu}`
        }
    })
})
$(".like").click(function () {
    let likeBtn = $(this)
    $.post("../../src/request.php", {
            like_id: $(this).data("id"),
            owner_like_id: $(this).data("owner")
        }, null, "JSON")
        .done(function (res) {
            console.log(res);
            if (res == "Liked") {
                likeBtn.addClass("red")
            } else {
                likeBtn.removeClass("red")
            }
        })
})
$(".down-btn").click(function () {
    let downBtn = $(this)
    $.post("../../src/request.php", {
            download_id: $(this).data("id"),
            owner_download_id: $(this).data("owner")
        }, null, "JSON")
        .done(function (res) {
            location.href = `${location.origin}/assets/books/${downBtn.data("book")}`
            downBtn.text("Downloading...")
            setTimeout(() => {
                downBtn.text("Download")
            }, 3000);
        })
})
$(".toggler").click(function () {
    $("aside").toggleClass("slide")
})
$(".side-links li").click(function () {
    $("aside").toggleClass("slide")
})
$(".close").click(function () {
    $(".overlayy").hide()
    $("#the-canvas").hide()
})
$(".read").click(function () {
    $(".overlayy").css({
        display: "grid"
    })
    $("#the-canvas").show()
    var url = `../../assets/books/${$(this).data('book')}`;

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    let context;
    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
    let container = document.getElementById("the-canvas")

    // Asynchronous download of PDF
    var loadingTask = pdfjsLib.getDocument(url)
        .promise
        .then(pdf => {
            // Loop through each page
            const pageCount = pdf.numPages;
            const promises = [];

            for (let pageNumber = 1; pageNumber <= pageCount; pageNumber++) {
                promises.push(
                    pdf.getPage(pageNumber)
                    .then(page => {
                        // Render each page
                        const viewport = page.getViewport({
                            scale: 1.5
                        });
                        const canvas = document.createElement('canvas');
                        context = canvas.getContext('2d');

                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport,
                        };

                        return page.render(renderContext).promise
                            .then(() => {
                                // Append the canvas element to the container
                                container.appendChild(canvas);
                            });
                    })
                );
            }

            // Wait for all pages to render
            $(".overlay .spinner-border").hide()
            return Promise.all(promises);
        })
        .catch(error => {
            console.error('Error loading PDF:', error);
        });
})
setTimeout(() => {
    $(".alert").remove()
}, 2000);
let limit = 10
let offset = 10
$("#loadMore").click(function () {
    $(".books").append(`
        <div class="spinner-border text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `)
    $.post("../../src/request.php", {
        limit,
        offset
    }, null, "JSON").done(function (res) {
        if (typeof res == "string") {
            setTimeout(() => {
                $(".books").find(".spinner-border").remove()
            }, 500);
            $(".books").prepend(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${res}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `)
            $("#loadMore").remove()
            setTimeout(() => {
                $(".alert").remove()
            }, 2000);
        }
        $.each(res, function (i, el) {
            $.post("../../src/request.php", {
                    category_id: el.category_id
                }, null, "JSON")
                .done(function (resp) {
                    $(".books").find(".spinner-border").remove()
                    $(".books").append(`
                        <div class="book-ju" data-id="${el.id}" data-owner="${el.owner_id}">
                            <div class="image">
                                <img src="./assets/images/${el.cover}" alt="">
                            </div>
                            <div class="details">
                                <div class="top">
                                    <span class="author">${el.author}</span>
                                    <span class="book-category">
                                        ${resp[0].category}
                                    </span>
                                </div>
                                <div class="bottom">
                                    <span class="title">
                                        ${el.name}
                                    </span>
                                </div>
                            </div>
                        </div>
                     `)
                    $(".book-ju").click(function () {
                        let book = $(this)
                        $.post("../../src/request.php", {
                                viewed: $(this).data("id"),
                                owner: $(this).data("owner")
                            }, null, "JSON")
                            .done(function (res) {
                                location.href = `${location.origin}/book.php?id=${book.data("id")}`
                            })
                    })
                })
        });
        offset += limit
    })
})
$(".view").click(function () {
    $.post("../../src/request.php", {
            book_id: $(this).data("id")
        }, null, "JSON")
        .done(function (res) {
            $(".modal-title").text(res[0].name)
            $("#bookMode").find(".cover").prop({
                src: `../../assets/images/${res[0].cover}`
            })
            $("#bookMode").find(".likes span").text(res[0].likes)
            $("#bookMode").find(".uploaded-on span").text(res[0].uploaded_on)
            $("#bookMode").find(".updated-on span").text(res[0].modified_on)
            $("#bookMode").find(".author span").text(res[0].author)
            $.post("../../src/request.php", {
                        category_id: res[0].category_id
                    }, null,
                    "JSON"
                )
                .done(function (res) {
                    $("#bookMode").find(".cat span").text(res[0].category)
                })
            $.post("../../src/request.php", {
                        owner_id: res[0].owner_id
                    }, null,
                    "JSON"
                )
                .done(function (res) {
                    $("#bookMode").find(".upby span").text(res[0].username)
                })
        })
    $.post("../../src/request.php", {
            viewed: $(this).data("id"),
            owner: $(this).data("owner")
        }, null, "JSON")
        .done(function (res) {})
})
$(".book-ju").click(function () {
    let book = $(this)
    $.post("../../src/request.php", {
            viewed: $(this).data("id"),
            owner: $(this).data("owner")
        }, null, "JSON")
        .done(function (res) {
            location.href = `${location.origin}/book.php?id=${book.data("id")}`
        })
})
var app = document.querySelector('.typing');

var typewriter = new Typewriter(app, {
        delay: 30
    }

);
typewriter.typeString("Welcome to Reader's Haven, where our vibrant community of Contributors brings a world of books to your fingertips!. ").pauseFor(300).typeString("At Reader 's Haven, we believe in the power of sharing and collaboration when it comes to literature. ").pauseFor(300).typeString("Our platform thrives on the passion and expertise of our dedicated Contributors, who play a crucial role in expanding our extensive book collection.").pauseFor(200).start()