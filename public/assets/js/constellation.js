function Constellation(i) {
    function n() {
        this.x = Math.random() * i.width, this.y = Math.random() * i.height, this.vx = t.config.velocity - .5 * Math.random(), this.vy = t.config.velocity - .5 * Math.random(), this.radius = Math.random()
    }
    var t = this,
        o = i.getContext("2d");
    n.prototype = {
        create: function() {
            o.beginPath(), o.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, !1), o.fill()
        },
        animate: function() {
            var n;
            for (n = 0; n < t.config.length; n++) {
                var o = t.config.stars[n];
                o.y < 0 || o.y > i.height ? (o.y = 0, o.vx = o.vx, o.vy = -o.vy) : (o.x < 0 || o.x > i.width) && (o.x = 0, o.vx = -o.vx, o.vy = o.vy), o.x += o.vx, o.y += o.vy
            }
        },
        line: function() {
            var i, n, e, a, c = t.config.length;
            for (e = 0; c > e; e++)
                for (a = 0; c > a; a++) i = t.config.stars[e], n = t.config.stars[a], i.x - n.x < t.config.distance && i.y - n.y < t.config.distance && i.x - n.x > -t.config.distance && i.y - n.y > -t.config.distance && i.x - t.config.position.x < t.config.radius && i.y - t.config.position.y < t.config.radius && i.x - t.config.position.x > -t.config.radius && i.y - t.config.position.y > -t.config.radius && (o.beginPath(), o.moveTo(i.x, i.y), o.lineTo(n.x, n.y), o.stroke(), o.closePath())
        }
    }, t.config = {
        star: {
            color: "rgba(255, 255, 255, .5)"
        },
        line: {
            color: "rgba(255, 255, 255, .2)",
            width: .2
        },
        position: {
            x: .5 * i.width,
            y: .5 * i.height
        },
        velocity: .1,
        length: 160,
        distance: 150,
        radius: 200,
        stars: []
    }, t.createStars = function() {
        var e, a, c = t.config.length;
        for (o.clearRect(0, 0, i.width, i.height), a = 0; c > a; a++) t.config.stars.push(new n), e = t.config.stars[a], e.create();
        e.line(), e.animate()
    }, t.setCanvas = function() {
        i.width = window.innerWidth, i.height = window.innerHeight
    }, t.setContext = function() {
        o.fillStyle = t.config.star.color, o.strokeStyle = t.config.line.color, o.lineWidth = t.config.line.width
    }, t.loop = function(i) {
        i(), reqAnimFrame(function() {
            t.loop(i)
        })
    }, t.bind = function() {
        $(window).on("mousemove", function(i) {
            t.config.position.x = i.pageX, t.config.position.y = i.pageY
        }).on("resize", function() {
            t.setCanvas(), t.setContext()
        })
    }, t.init = function() {
        t.setCanvas(), t.setContext(), t.loop(function() {
            t.createStars()
        }), t.bind()
    }
}
var reqAnimFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame || function(i) {
        window.setTimeout(i, 1e3 / 60)
    },
    app = window.app || {};
app.bind = function() {
    var i = this;
    $(document).on("readystatechange", function() {
        "complete" === document.readyState && i.constellation.init()
    })
}, app.init = function() {
    app.constellation = new Constellation($("#background")[0]), this.bind()
}, app.init();