window.addEventListener("load", () => {
  // Contenidor on s'afegiran els botons
  const usuarisContainer = document.getElementById("usuaris-botons");
  const id_projecte = usuarisContainer.dataset.projecte; // Obtenir l'ID del projecte des del data attribute

  if (!usuarisContainer) {
    console.error("El contenidor #usuaris-botons no existeix.");
    return;
  }

  // Obtenir l'ID del projecte des de la URL
  // const params = new URLSearchParams(window.location.search);
  // const idProjecte = params.get('id_projecte');

  if (!id_projecte) {
    alert("No s'ha proporcionat cap ID de projecte.");
    return;
  }
  // Crear el botó per esborrar el projecte
  const deleteButton = document.createElement("button");
  deleteButton.className = "btn btn-danger m-2";
  deleteButton.textContent = "Esborrar projecte";

  // Esdeveniment per gestionar el clic al botó d'esborrar projecte
  deleteButton.addEventListener("click", () => {
    if (
      !confirm(
        "Estàs segur que vols esborrar aquest projecte? Aquesta acció no es pot desfer."
      )
    ) {
      return;
    }

    // Cridar a l'API per esborrar el projecte
    fetch("api/esborrar_projecte.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `id_projecte=${id_projecte}`,
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.success) {
          alert(response.message);
          // Redirigir a la pàgina principal
          window.location.href = "index.php"; // Canvia això segons la teva estructura de rutes
        } else {
          alert(`Error: ${response.message}`);
        }
      })
      .catch((err) => {
        console.error("Error al esborrar el projecte:", err);
      });
  });

  // Afegir el botó d'esborrar projecte al contenidor
  usuarisContainer.appendChild(deleteButton);

  // Obtenir els usuaris del projecte des de l'API
  fetch(`api/obtenir_colaboradors.php?id_projecte=${id_projecte}`)
    .then((res) => res.json())
    .then((usuaris) => {
      if (usuaris.error) {
        alert(usuaris.error);
        return;
      }

      // Crear un botó per a cada usuari
      usuaris.forEach((usuari) => {
        const button = document.createElement("button");
        button.className = "btn btn-primary m-2";
        button.textContent = usuari.nom;
        button.dataset.idUsuari = usuari.id_usuari;

        // Contenidor per a les tasques del col·laborador
        const tasquesContainer = document.createElement("div");
        tasquesContainer.className = "tasques-container mt-2";

        // Esdeveniment per gestionar el clic al botó del col·laborador
        button.addEventListener("click", () => {
          console.log(`Botó clicat: ${usuari.nom}`);
          const nomTasca = prompt(
            `Introdueix el nom de la tasca per a ${usuari.nom}:`
          );
          if (!nomTasca) {
            alert("El nom de la tasca no pot estar buit.");
            return;
          }

          const idEstat = 1; // Exemple: 1 = "Pendent"
          const descripcio = prompt(
            "Introdueix una descripció per a la tasca:"
          );
          const idTipus = prompt(
            "Introdueix el tipus de tasca (1 -> Frontend o 2 -> Backend ):"
          );
          const dataInici = prompt(
            "Introdueix la data d'inici (YYYY-MM-DD, opcional):"
          );
          const dataFi = prompt(
            "Introdueix la data de fi (YYYY-MM-DD, opcional):"
          );

          // Cridar a l'API per crear la tasca
          fetch("api/crear_tasca.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `id_projecte=${id_projecte}&id_usuari=${
              usuari.id_usuari
            }&nom_tasca=${encodeURIComponent(
              nomTasca
            )}&id_estat=${idEstat}&descripcio=${encodeURIComponent(
              descripcio
            )}&id_tipus=${idTipus}&data_inici=${dataInici}&data_fi=${dataFi}`,
          })
            .then((res) => res.json())
            .then((response) => {
              if (response.success) {
                alert(response.message);
                // Tornar a carregar les tasques després de crear-ne una
                carregarTasques(
                  usuari.id_usuari,
                  tasquesContainer,
                  id_projecte
                );
              } else {
                alert(`Error: ${response.message}`);
              }
            })
            .catch((err) => {
              console.error("Error al crear la tasca:", err);
            });
        });

        // Afegir el botó i el contenidor de tasques al contenidor principal
        usuarisContainer.appendChild(button);
        usuarisContainer.appendChild(tasquesContainer);

        // Carregar les tasques inicialment
        carregarTasques(usuari.id_usuari, tasquesContainer, id_projecte);
      });
    })
    .catch((err) => {
      console.error("Error al carregar els usuaris:", err);
    });
});

// Funció per carregar les tasques d'un col·laborador i mostrar-les en targetes

function carregarTasques(idUsuari, tasquesContainer, id_projecte) {
  fetch(
    `api/seleccionar_tasques.php?id_usuari=${idUsuari}&id_projecte=${id_projecte}`
  )
    .then((res) => res.json())
    .then((tasques) => {
      tasquesContainer.innerHTML = "";

      if (tasques.length === 0) {
        tasquesContainer.innerHTML =
          "<p>No hi ha tasques per aquest col·laborador.</p>";
        return;
      }

      tasques.forEach((usuari) => {
        if (!usuari || !Array.isArray(usuari.tasques)) return;

        usuari.tasques.forEach((tasca) => {
          if (!tasca) return;

          // Crear la card de la tasca
          const tascaCard = document.createElement("div");
          tascaCard.className = "card mb-2";
          tascaCard.style =
            "border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background: #fff;";
          tascaCard.innerHTML = `
                        <h5>${tasca.nom_tasca}</h5>
                        <p><strong>Descripció:</strong> ${
                          tasca.descripcio
                            ? tasca.descripcio
                            : "Sense descripció"
                        }</p>
                        <p><strong>Data inici:</strong> ${
                          tasca.data_inici || "No especificada"
                        }</p>
                        <p><strong>Data fi:</strong> ${
                          tasca.data_fi || "No especificada"
                        }</p>
                        <p><strong>Estat:</strong> ${
                          tasca.estat || "No especificat"
                        }</p>
                    `;

          // Crear el board de 3 columnes per aquesta tasca
          const board = document.createElement("div");
          board.style.display = "flex";
          board.style.gap = "10px";
          board.style.marginTop = "10px";

          const estats = ["Per començar", "En procés", "Finalitzat"];
          estats.forEach((estat, id) => {
            const col = document.createElement("div");
            col.className = "tasca-col";
            col.style.flex = "1";
            col.style.minHeight = "60px";
            col.style.border = "1px solid #ccc";
            col.style.padding = "5px";
            col.style.background = "#f9f9f9";
            col.setAttribute("data-estat", estat);

            const h = document.createElement("h6");
            h.textContent = estat;
            col.appendChild(h);

            if (
              (id === 0 &&
                (!tasca.estat ||
                  tasca.estat === "Pendent" ||
                  tasca.estat === "Per començar")) ||
              (id === 1 && tasca.estat === "En procés") ||
              (id === 2 && tasca.estat === "Finalitzat")
            ) {
              const draggable = document.createElement("div");
              draggable.className = "card mb-2";
              draggable.style =
                "border: 1px solid #ccc; padding: 10px; background: #fff; cursor: grab;";
              draggable.setAttribute("draggable", "true");
              draggable.setAttribute("data-id", tasca.id_tasca);
              draggable.innerHTML = `<strong>${tasca.nom_tasca}</strong>`;

              draggable.addEventListener("dragstart", (e) => {
                e.dataTransfer.setData("text/plain", tasca.id_tasca);
                draggable.classList.add("dragging");
              });
              draggable.addEventListener("dragend", () => {
                draggable.classList.remove("dragging");
              });

              col.appendChild(draggable);
            }

            col.addEventListener("dragover", (e) => {
              e.preventDefault();
              col.style.background = "#e0e0e0";
            });
            col.addEventListener("dragleave", () => {
              col.style.background = "#f9f9f9";
            });
            col.addEventListener("drop", (e) => {
              e.preventDefault();
              col.style.background = "#f9f9f9";

              const tascaId = e.dataTransfer.getData("text/plain");
              const tascaCard2 = board.querySelector(`[data-id='${tascaId}']`);

              if (tascaCard2) {
                col.appendChild(tascaCard2);

                // Mapa de noms d'estat al seu id en base de dades
                const estatMap = {
                  "Per començar": 1,
                  "En procés": 2,
                  "Finalitzat": 3,
                };

                const nouEstat = col.getAttribute("data-estat");
                const idEstat = estatMap[nouEstat];

                // Enviem la petició per actualitzar l'estat a la base de dades
                fetch("api/actualitzar_estat.php", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                  },
                  body: `id_tasca=${tascaId}&id_estat=${idEstat}`,
                })
                  .then((res) => res.json())
                  .then((data) => {
                    if (!data.success) {
                      alert("Error en actualitzar la tasca: " + data.message);
                    } else {
                      // Actualitzar text a la card de la tasca
                      const estatText = tascaCard2
                        .closest(".card")
                        .querySelector("p:last-child");
                      if (estatText) {
                        estatText.innerHTML = `<strong>Estat:</strong> ${nouEstat}`;
                      }
                    }
                  })
                  .catch((err) => {
                    console.error("Error en la petició:", err);
                  });
              }
            });

            board.appendChild(col);
          });

          tasquesContainer.appendChild(tascaCard);
          tasquesContainer.appendChild(board);
        });
      });
    })
    .catch((err) => {
      console.error("Error al carregar les tasques:", err);
    });
}
