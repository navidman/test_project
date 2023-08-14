$(document).ready(function () {
    var $chkboxes = $('.delete-checkbox');
    var lastChecked = null;

    $chkboxes.click(function (e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });
});


function CustomElement() {
    var x, i, j, selElmnt, a, b, c;
    x = document.getElementsByClassName("custom-select-field");
    for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < selElmnt.length; j++) {
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.setAttribute("data-value", selElmnt.options[j].value);
            c.addEventListener("click", function (e) {
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        this.parentElement.parentElement.getElementsByTagName("select")[0].getElementsByTagName("option")[i].setAttribute("selected", "selected");
                        if (this.parentElement.parentElement.getElementsByTagName("select")[0].classList.contains("condition-select")) {
                            conditionSelector(this.parentElement.parentElement.parentElement, this.getAttribute('data-value'), null);
                        }
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            e.stopPropagation();
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }
}

CustomElement();

function closeAllSelect(elmnt) {
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < x.length; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}

document.addEventListener("click", closeAllSelect);

$(document).ready(function () {
    $(".number-format").on('keyup', function () {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    });
    $(".number-format-only").on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
    });
    $(".percentage-limit").on('keyup', function () {
        if (Number(this.value) > 100)
        {
            this.value = 100
        }
    });
});
