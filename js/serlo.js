import { EditorWebComponent } from "@serlo/editor-web-component";

export const init = (initialState) => {
  customElements.define("serlo-editor", EditorWebComponent);
  requestAnimationFrame(() => {
    const editor = document.querySelector("serlo-editor");
    const input = document.querySelector("input[type=hidden][name=state]");
    console.log(initialState);
    editor.initialState = JSON.parse(initialState);
    editor.addEventListener(
      "state-changed",
      (stateEvent) =>
        (input.value = JSON.stringify(stateEvent.detail.newState)),
    );
  });
};
