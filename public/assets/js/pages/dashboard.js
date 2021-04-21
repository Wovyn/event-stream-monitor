var Dashboard = function() {

    var hierarchy = {};

    hierarchy.chart = function(settings) {
        const root = hierarchy.tree(settings);

        console.log(root);

        let width = settings.container.width(),
            x0 = Infinity,
            x1 = -x0;

        root.each(d => {
            if (d.x > x1) x1 = d.x;
            if (d.x < x0) x0 = d.x;
        });

        const svg = d3.create("svg")
            .attr("viewBox", [0, 0, width, x1 - x0 + root.dx * 2]);

        const g = svg.append("g")
            .attr("font-family", settings.font.family)
            .attr("font-size", settings.font.size)
            .attr("transform", `translate(${root.dy / 3},${root.dx - x0})`);

        const link = g.append("g")
            .attr("fill", "none")
            .attr("stroke", "#555")
            .attr("stroke-opacity", 0.4)
            .attr("stroke-width", 1.5)
        .selectAll("path")
        .data(root.links())
            .join("path")
            .attr("d", d3.linkHorizontal()
                .x(d => d.y)
                .y(d => d.x));

        const node = g.append("g")
            .attr("stroke-linejoin", "round")
            .attr("stroke-width", 3)
        .selectAll("g")
        .data(root.descendants())
        .join("g")
            .attr("transform", d => `translate(${d.y},${d.x})`);

        node.append("circle")
            .attr("fill", d => d.children ? "#555" : "#999")
            .attr("r", 2.5);

        node.append("text")
            .attr("dy", "0.31em")
            .attr("x", d => d.children ? -6 : 6)
            .attr("text-anchor", d => d.children ? "end" : "start")
            .text(d => d.data.name)
        .clone(true).lower()
            .attr("stroke", "white");

        settings.container.append(svg.node());
    }

    hierarchy.tree = function(settings) {
        let width = settings.container.width(),
            root = d3.hierarchy(settings.data);

        console.log(root);

        root.dx = settings.font.size * 2;
        root.dy = width / (root.height + 1);

        return d3.tree().nodeSize([root.dx, root.dy])(root);
    }

    return {
        init: function() {
            console.log('Dashboard.init');

            App.globalPageChecks();

            $.get('/dashboard/chartdata', function(data) {
                if(_.isEmpty(data)) {
                    $('#d3-hierarchy').append('<p class="text-center">There are currently no Event Stream Sinks defined!</p>');
                } else {
                    CollapseTree.chart({
                        container: $('#d3-hierarchy'),
                        depth: 3,
                        font: {
                            family: 'Open Sans',
                            size: 12
                        },
                        margin: {top: 10, right: 120, bottom: 10, left: 120},
                        data: {
                            name: 'Event Streams',
                            children: data
                        }
                    });

                    // hierarchy.chart({
                    //     container: $('#d3-hierarchy'),
                    //     font: {
                    //         family: 'Open Sans',
                    //         size: 12
                    //     },
                    //     data: {
                    //         name: 'Event Streams',
                    //         children: data
                    //     }
                    // });
                }
            });
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});