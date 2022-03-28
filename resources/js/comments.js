document.addEventListener("alpine:init", () => {
    Alpine.data("compose", ({ text, defer = false } = {}) => {
        // Store the editor as a non-reactive instance property
        let editor;

        return {
            text,

            init() {
                if (editor) {
                    return;
                }

                const textarea = this.$el.querySelector("textarea");

                if (!textarea) {
                    return;
                }

                editor = new SimpleMDE({
                    element: textarea,
                    hideIcons: [
                        "heading",
                        "image",
                        "preview",
                        "side-by-side",
                        "fullscreen",
                        "guide",
                    ],
                    spellChecker: false,
                    status: false,
                });

                editor.value(this.text);

                editor.codemirror.on("change", () => {
                    this.text = editor.value();
                });
            },

            clear() {
                editor.value("");
            },
        };
    });
});
