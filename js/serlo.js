import { EditorWebComponent } from "@serlo/editor-web-component";
import { call } from "core/ajax";
import { addNotification } from "core/notification";
import { addIconToContainerWithPromise } from "core/loadingicon";
import { get_string } from "core/str";

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
    const message = await get_string("serlosaveerror", "mod_serlo");
    addNotification({
      message: `${message}: ${result.reason.message}`,
      type: "error",
    });
  } else {
    const message = await get_string("serlosaved", "mod_serlo");
    addNotification({ message, type: "info" });
  }
};

export const init = async (serloid) => {
  customElements.define("serlo-editor", EditorWebComponent);

  const editor = document.querySelector("serlo-editor");
  const saveButton = document.getElementById("mod_serlo_save");
  saveButton?.addEventListener("click", () =>
    saveEditorState(serloid, editor.currentState),
  );
  editor.addEventListener("state-changed", () => {
    saveButton?.classList.remove("disabled");
    window.addEventListener("beforeunload", (e) => {
      e.preventDefault();
      e.returnValue = true;
    });
  });

  const loaderContainer = document.querySelector(".serlo.loader-wrapper");
  const loader = addIconToContainerWithPromise(loaderContainer);
  const [initialState] = await Promise.all(
    call([
      {
        methodname: "mod_serlo_get_serlo_state",
        args: { serloid },
      },
    ]),
  );
  if (initialState) editor.initialState = JSON.parse(initialState);
  editor.classList.remove("hidden");
  loader.resolve();
};
