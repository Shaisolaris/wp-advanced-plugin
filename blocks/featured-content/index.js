(function(wp) {
    const { registerBlockType } = wp.blocks;
    const { useBlockProps, InspectorControls } = wp.blockEditor;
    const { PanelBody, SelectControl, RangeControl } = wp.components;
    const { createElement: el, useState, useEffect } = wp.element;

    registerBlockType('wp-advanced/featured-content', {
        title: 'Featured Content',
        icon: 'grid-view',
        category: 'widgets',
        attributes: {
            postType: { type: 'string', default: 'portfolio' },
            postsPerPage: { type: 'number', default: 3 },
            columns: { type: 'number', default: 3 },
        },
        edit: function(props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();
            return el('div', blockProps,
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Content Settings' },
                        el(SelectControl, { label: 'Post Type', value: attributes.postType, options: [{ label: 'Portfolio', value: 'portfolio' }, { label: 'Services', value: 'service' }, { label: 'Testimonials', value: 'testimonial' }], onChange: function(val) { setAttributes({ postType: val }); } }),
                        el(RangeControl, { label: 'Posts', value: attributes.postsPerPage, onChange: function(val) { setAttributes({ postsPerPage: val }); }, min: 1, max: 12 }),
                        el(RangeControl, { label: 'Columns', value: attributes.columns, onChange: function(val) { setAttributes({ columns: val }); }, min: 1, max: 4 })
                    )
                ),
                el('div', { className: 'wp-advanced-featured-preview', style: { display: 'grid', gridTemplateColumns: 'repeat(' + attributes.columns + ', 1fr)', gap: '16px' } },
                    Array.from({ length: attributes.postsPerPage }, function(_, i) {
                        return el('div', { key: i, style: { padding: '20px', background: '#f0f0f0', borderRadius: '8px', textAlign: 'center' } },
                            el('div', { style: { width: '100%', height: '120px', background: '#ddd', borderRadius: '4px', marginBottom: '8px' } }),
                            el('strong', {}, attributes.postType + ' item ' + (i + 1))
                        );
                    })
                )
            );
        },
        save: function() { return null; },
    });
})(window.wp);
