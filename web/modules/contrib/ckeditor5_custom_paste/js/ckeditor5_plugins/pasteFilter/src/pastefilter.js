import { Plugin } from "ckeditor5/src/core";
import { ClipboardPipeline } from "ckeditor5/src/clipboard";

export default class PasteFilter extends Plugin {
  static get pluginName() {
    return "PasteFilter";
  }

  static get requires() {
    return [ClipboardPipeline];
  }

  init() {
    // Don't do anything if the plugin is not enabled.
    if (this.editor.config.get("pastefilter").enabled !== true) {
      return;
    }

    this.editor.plugins
      .get("ClipboardPipeline")
      .on("inputTransformation", (evt, data) => {
        const excludedTags = this.editor.config.get("excluded_tags") || [];
        let html = this.editor.data.htmlProcessor.toData(data.content);

        html = html.replace(/<[^>]+>/gi, match => {
          const shouldExclude =
            Array.isArray(excludedTags) &&
            excludedTags.length > 0 &&
            excludedTags.some(tag =>
              new RegExp(`</?${tag}\\b`, "i").test(match)
            );

          if (shouldExclude) {
            // Remove all attributes from excluded tags
            return match.replace(/<(\w+)[^>]*>/gi, "<$1>");
          }

          if (match.match(/<\/?br\s*\/?>/i)) {
            return match; // Keep <br> tags
          }

          return "</p><p>"; // Replace other tags with </p><p>
        });

        // Remove consecutive <p> tags resulting from tag replacements
        html = html.replace(/<\/p><p>/gi, "</p>\n<p>");

        // Wrap the entire content with <p> tags and remove empty paragraphs
        html = `<p>${html.trim()}</p>`;
        html = html.replace(/<p>\s*<\/p>/gi, "");

        data.content = this.editor.data.htmlProcessor.toView(html);
      });
  }
}
