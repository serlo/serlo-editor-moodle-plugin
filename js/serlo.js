import { EditorWebComponent } from "@serlo/editor-web-component";

export const init = () => {
  customElements.define("serlo-editor", EditorWebComponent);
};
