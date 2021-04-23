var CollapseTree = function() {

    var chart = {};
    chart.init = function(options) {
        const root = d3.hierarchy(options.data),
            width = options.container.width(),
            dx = options.node_spacingX,
            dy = options.container.width() / options.node_spacingY;

        root.x0 = dy / 2;
        root.y0 = 0;
        root.descendants().forEach((datapoint, key) => {
            datapoint.id = key;
            datapoint._children = datapoint.children;
            if (datapoint.depth && datapoint.data.name.length !== options.spacing) {
              datapoint.children = null;
            }
        });


        // init svg element
        const svg = d3.create('svg')
            .attr('viewBox', [-options.margin.left, -options.margin.top, width, dx])
            .attr('font-family', options.font.family)
            .attr('font-size', options.font.size)
            .style('user-select', 'none');

        // intit g element for lines
        const gLink = svg.append('g')
            .attr('fill', 'none')
            .attr('stroke', '#555')
            .attr('stroke-opacity', 0.4)
            .attr('stroke-width', 1.5);


        const gNode = svg.append('g')
            .attr('cursor', 'pointer')
            .attr('pointer-events', 'all');

        function update(source) {
            const duration = options.transition_duration;
            const nodes = root.descendants().reverse();
            const links = root.links();

            // Compute the new tree layout.
            tree(root);

            let left = root;
            let right = root;
            root.eachBefore(node => {
                if (node.x < left.x) left = node;
                if (node.x > right.x) right = node;
            });

            const height = right.x - left.x + options.margin.top + options.margin.bottom;

            const transition = svg.transition()
                .duration(duration)
                .attr("viewBox", [-options.margin.left, left.x - options.margin.top, width, height])
                .tween("resize", window.ResizeObserver ? null : () => () => svg.dispatch("toggle"));

            // Update the nodes…
            const node = gNode.selectAll("g")
                .data(nodes, d => d.id);

            // console.log(node);

            // Enter any new nodes at the parent's previous position.
            const nodeEnter = node.enter().append("g")
                .attr("transform", d => `translate(${source.y0},${source.x0})`)
                .attr("fill-opacity", 0)
                .attr("stroke-opacity", 0)
                .on("click", (event, d) => {
                    if (d.children) {
                        d._children = d.children;
                        d.children = null;
                    } else {
                        d.children = d._children;
                        d._children = null;
                    }

                    // if (d.parent) {
                    //     d.parent.children.forEach(function(element) {
                    //         if (d !== element) {
                    //             collapse(element);
                    //         }
                    //     });
                    // }

                    update(d);
                });

            nodeEnter.append("circle")
                .attr("r", 2.5)
                .attr("fill", d => d._children || d.children ? "#555" : "#999")
                .attr("stroke-width", 10);

            nodeEnter.append("text")
                .attr("dy", "0.31em")
                .attr("x", d => d._children || d.children ? -6 : 6)
                .attr("text-anchor", d => d._children || d.children ? "end" : "start")
                .text(d => d.data.name)
            .clone(true).lower()
                .attr("stroke-linejoin", "round")
                .attr("stroke-width", 3)
                .attr("stroke", "white");

            // Transition nodes to their new position.
            const nodeUpdate = node.merge(nodeEnter).transition(transition)
                .attr("transform", d => `translate(${d.y},${d.x})`)
                .attr("fill-opacity", 1)
                .attr("stroke-opacity", 1);

            // Transition exiting nodes to the parent's new position.
            const nodeExit = node.exit().transition(transition).remove()
                .attr("transform", d => `translate(${source.y},${source.x})`)
                .attr("fill-opacity", 0)
                .attr("stroke-opacity", 0);

            // Update the links…
            const link = gLink.selectAll("path")
                .data(links, d => d.target.id);

            // Enter any new links at the parent's previous position.
            const linkEnter = link.enter().append("path")
                .attr("d", d => d3.linkHorizontal().x(d => source.y).y(d => source.x)(root));

            // Transition links to their new position.
            link.merge(linkEnter).transition(transition)
                .attr("d", d3.linkHorizontal().x(d => d.y).y(d => d.x));

            // Transition exiting nodes to the parent's new position.
            link.exit().transition(transition).remove()
                .attr("d", d => d3.linkHorizontal().x(d => source.y0).y(d => source.x0)(root));

            // Stash the old positions for transition.
            root.eachBefore(d => {
                d.x0 = d.x;
                d.y0 = d.y;
            });
        }

        update(root);

        function tree() {
            return d3.tree().nodeSize([dx, dy])(root);
        }

        options.container.append(svg.node());
    }

    return {
        chart: chart.init
    }
}();