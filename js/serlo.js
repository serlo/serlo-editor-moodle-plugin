import { EditorWebComponent } from "@serlo/editor-web-component";
import { call } from "core/ajax";
import { addNotification } from "core/notification";
import { addIconToContainerWithPromise } from "core/loadingicon";

const saveEditorState = async (serloid, state) => {
  const [result] = await Promise.allSettled(
    call([
      {
        methodname: "mod_serlo_update_serlo_state",
        args: { serloid, state: JSON.stringify(state) },
      },
    ]),
  );
  if (result.status === "rejected") {
    addNotification({
      message: `Error while saving state: ${result.reason.message}`,
      type: "error",
    });
  } else {
    addNotification({
      message: "State saved!",
      type: "info",
    });
  }
};

export const init = async (serloid) => {
  customElements.define("serlo-editor", EditorWebComponent);

  const editor = document.querySelector("serlo-editor");
  const saveButton = document.getElementById("mod_serlo_save");
  saveButton.addEventListener("click", () =>
    saveEditorState(serloid, editor.currentState),
  );
  editor.addEventListener("state-changed", () =>
    saveButton.classList.remove("disabled"),
  );

  const loaderContainer = document.querySelector("#serlo-root > div");
  const loader = addIconToContainerWithPromise(loaderContainer);
  const [initialState] = await Promise.all(
    call([
      {
        methodname: "mod_serlo_get_serlo_state",
        args: { serloid },
      },
    ]),
  );
  editor.initialState = JSON.parse(initialState);
  editor.classList.remove("hidden");
  loader.resolve();
};
