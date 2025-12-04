// =============================================
// GymManager - Frontend JavaScript
// =============================================
// This file contains all the JavaScript functions
// for modals, filtering, and form validation.
// When integrating with PHP, replace the static
// data with dynamic PHP outputs.
// =============================================

// =============================================
// COURS (COURSES) MODAL FUNCTIONS
// =============================================

function openModal(mode, id = null) {
    const modal = document.getElementById("coursModal")
    const title = document.getElementById("modalTitle")
    const form = document.getElementById("coursForm")

    if (mode === "add") {
        title.textContent = "Ajouter un cours"
        form.reset()
        document.getElementById("coursId").value = ""
    } else if (mode === "edit") {
        title.textContent = "Modifier le cours"
        document.getElementById("coursId").value = id
        // PHP: Load course data via AJAX or pre-populate with PHP
        // Example: fetchCourseData(id);
    }

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeModal() {
    const modal = document.getElementById("coursModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

function confirmDelete(id) {
    const modal = document.getElementById("deleteModal")
    const link = document.getElementById("deleteLink")

    // PHP: Update this to your delete endpoint
    link.href = "delete2.php?id=" + id

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeDeleteModal() {
    const modal = document.getElementById("deleteModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

// =============================================
// EQUIPEMENTS (EQUIPMENT) MODAL FUNCTIONS
// =============================================

function openEquipModal(mode, id = null) {
    const modal = document.getElementById("equipModal")
    const title = document.getElementById("equipModalTitle")
    const form = document.getElementById("equipForm")

    if (mode === "add") {
        title.textContent = "Ajouter un équipement"
        form.reset()
        document.getElementById("equipId").value = ""
    } else if (mode === "edit") {
        title.textContent = "Modifier l'équipement"
        document.getElementById("equipId").value = id
        // PHP: Load equipment data via AJAX or pre-populate with PHP
        // Example: fetchEquipmentData(id);
    }

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeEquipModal() {
    const modal = document.getElementById("equipModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

function confirmDeleteEquip(id) {
    const modal = document.getElementById("deleteEquipModal")
    const link = document.getElementById("deleteEquipLink")

    // PHP: Update this to your delete endpoint
    link.href = "delete.php?id=" + id

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeDeleteEquipModal() {
    const modal = document.getElementById("deleteEquipModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

// =============================================
// ASSOCIATIONS MODAL FUNCTIONS
// =============================================

function openAssocModal() {
    const modal = document.getElementById("assocModal")
    const form = document.getElementById("assocForm")
    form.reset()

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeAssocModal() {
    const modal = document.getElementById("assocModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

function confirmDeleteAssoc(idCours, idEquip) {
    const modal = document.getElementById("deleteAssocModal")
    const link = document.getElementById("deleteAssocLink")

    // PHP: Update this to your delete endpoint
    link.href = "delete_association.php?id_cours=" + idCours + "&id_equipement=" + idEquip

    modal.classList.remove("hidden")
    modal.classList.add("flex")
}

function closeDeleteAssocModal() {
    const modal = document.getElementById("deleteAssocModal")
    modal.classList.add("hidden")
    modal.classList.remove("flex")
}

// =============================================
// SEARCH & FILTER FUNCTIONS
// =============================================

// Search courses
const searchInput = document.getElementById("searchInput")
if (searchInput) {
    searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase()
        const rows = document.querySelectorAll("#coursTableBody tr")

        rows.forEach((row) => {
            const text = row.textContent.toLowerCase()
            row.style.display = text.includes(searchTerm) ? "" : "none"
        })
    })
}

// Filter courses by category
const categoryFilter = document.getElementById("categoryFilter")
if (categoryFilter) {
    categoryFilter.addEventListener("change", function () {
        const category = this.value
        const rows = document.querySelectorAll("#coursTableBody tr")

        rows.forEach((row) => {
            if (!category) {
                row.style.display = ""
            } else {
                const rowCategory = row.querySelector("td:nth-child(2) span")
                if (rowCategory && rowCategory.textContent === category) {
                    row.style.display = ""
                } else {
                    row.style.display = "none"
                }
            }
        })
    })
}

// Search equipment
const searchEquip = document.getElementById("searchEquip")
if (searchEquip) {
    searchEquip.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase()
        const cards = document.querySelectorAll("#equipementGrid > div")

        cards.forEach((card) => {
            const text = card.textContent.toLowerCase()
            card.style.display = text.includes(searchTerm) ? "" : "none"
        })
    })
}

// Filter equipment by type
const typeFilter = document.getElementById("typeFilter")
if (typeFilter) {
    typeFilter.addEventListener("change", function () {
        const type = this.value
        const cards = document.querySelectorAll("#equipementGrid > div")

        cards.forEach((card) => {
            if (!type) {
                card.style.display = ""
            } else {
                const cardType = card.querySelector("p.text-sm.text-gray-500")
                if (cardType && cardType.textContent.includes(type)) {
                    card.style.display = ""
                } else {
                    card.style.display = "none"
                }
            }
        })
    })
}

// Filter equipment by state
const etatFilter = document.getElementById("etatFilter")
if (etatFilter) {
    etatFilter.addEventListener("change", function () {
        const etat = this.value
        const cards = document.querySelectorAll("#equipementGrid > div")

        cards.forEach((card) => {
            if (!etat) {
                card.style.display = ""
            } else {
                const badge = card.querySelector('span[class*="rounded-full"]')
                if (badge && badge.textContent.toLowerCase().includes(etat.toLowerCase())) {
                    card.style.display = ""
                } else {
                    card.style.display = "none"
                }
            }
        })
    })
}

// =============================================
// FORM VALIDATION
// =============================================

// Course form validation
const coursForm = document.getElementById("coursForm")
if (coursForm) {
    coursForm.addEventListener("submit", (e) => {
        // PHP: Remove this preventDefault when integrating with PHP
        // The form will submit normally to your PHP endpoint




        const nom = document.getElementById("nomCours").value.trim()
        const categorie = document.getElementById("categorie").value
        const date = document.getElementById("dateCours").value
        const heure = document.getElementById("heure").value
        const duree = document.getElementById("duree").value
        const max = document.getElementById("maxParticipants").value

        if (!nom || !categorie || !date || !heure || !duree || !max) {
            showToast("Veuillez remplir tous les champs obligatoires", "error")
            return
        }

        // PHP: Form will submit to your save_cours.php
        // For demo, we just close the modal
        showToast("Cours enregistré avec succès!", "success")
        closeModal()

        // PHP: Uncomment this line when integrating
        // this.submit();
    })
}

// Equipment form validation
const equipForm = document.getElementById("equipForm")
if (equipForm) {
    equipForm.addEventListener("submit", (e) => {
        // PHP: Remove this preventDefault when integrating with PHP

        const nom = document.getElementById("nomEquip").value.trim()
        const type = document.getElementById("typeEquip").value
        const qte = document.getElementById("qteEquip").value
        const etat = document.getElementById("etatEquip").value

        if (!nom || !type || !qte || !etat) {
            showToast("Veuillez remplir tous les champs obligatoires", "error")
            return
        }

        // PHP: Form will submit to your save_equipement.php
        showToast("Équipement enregistré avec succès!", "success")
        closeEquipModal()

        // PHP: Uncomment this line when integrating
        // this.submit();
    })
}

// Association form validation
const assocForm = document.getElementById("assocForm")
if (assocForm) {
    assocForm.addEventListener("submit", (e) => {
        // PHP: Remove this preventDefault when integrating with PHP

        const cours = document.getElementById("assocCours").value
        const equip = document.getElementById("assocEquip").value

        if (!cours || !equip) {
            showToast("Veuillez sélectionner un cours et un équipement", "error")
            return
        }

        // PHP: Form will submit to your save_association.php
        showToast("Association créée avec succès!", "success")
        closeAssocModal()

        // PHP: Uncomment this line when integrating
        // this.submit();
    })
}

// =============================================
// TOAST NOTIFICATIONS
// =============================================

function showToast(message, type = "success") {
    // Remove existing toasts
    const existingToast = document.querySelector(".toast")
    if (existingToast) {
        existingToast.remove()
    }

    const toast = document.createElement("div")
    toast.className = `toast toast-${type}`
    toast.textContent = message
    document.body.appendChild(toast)

    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = "slideIn 0.3s ease reverse"
        setTimeout(() => toast.remove(), 300)
    }, 3000)
}

// =============================================
// CLOSE MODALS ON OUTSIDE CLICK
// =============================================

document.addEventListener("click", (e) => {
    // Close course modal
    const coursModal = document.getElementById("coursModal")
    if (coursModal && e.target === coursModal) {
        closeModal()
    }

    // Close delete modal
    const deleteModal = document.getElementById("deleteModal")
    if (deleteModal && e.target === deleteModal) {
        closeDeleteModal()
    }

    // Close equipment modal
    const equipModal = document.getElementById("equipModal")
    if (equipModal && e.target === equipModal) {
        closeEquipModal()
    }

    // Close delete equipment modal
    const deleteEquipModal = document.getElementById("deleteEquipModal")
    if (deleteEquipModal && e.target === deleteEquipModal) {
        closeDeleteEquipModal()
    }

    // Close association modal
    const assocModal = document.getElementById("assocModal")
    if (assocModal && e.target === assocModal) {
        closeAssocModal()
    }

    // Close delete association modal
    const deleteAssocModal = document.getElementById("deleteAssocModal")
    if (deleteAssocModal && e.target === deleteAssocModal) {
        closeDeleteAssocModal()
    }
})

// =============================================
// KEYBOARD SHORTCUTS
// =============================================

document.addEventListener("keydown", (e) => {
    // Close modals on Escape
    if (e.key === "Escape") {
        closeModal()
        closeDeleteModal()
        closeEquipModal()
        closeDeleteEquipModal()
        closeAssocModal()
        closeDeleteAssocModal()
    }
})

// =============================================
// MOBILE SIDEBAR TOGGLE
// =============================================

function toggleSidebar() {
    const sidebar = document.querySelector("aside")
    sidebar.classList.toggle("open")
}

// =============================================
// PHP INTEGRATION NOTES
// =============================================
/*
To integrate with PHP:

1. FORMS:
   - Add action="your_php_file.php" and method="POST" to forms
   - Remove e.preventDefault() from form submit handlers
   - Uncomment this.submit() lines

2. DATA LOADING:
   - Replace static HTML with PHP loops: <?php foreach($data as $item): ?>
   - Use <?php echo $variable; ?> for dynamic values

3. DELETE LINKS:
   - Update href in confirmDelete functions to point to your PHP endpoints
   - Example: delete_cours.php?id=<?php echo $id; ?>

4. FILTERS:
   - For server-side filtering, change select onchange to submit a form
   - Or use AJAX to fetch filtered results

5. SESSION MESSAGES:
   - Add PHP session flash messages for success/error notifications
   - Example: <?php if(isset($_SESSION['message'])): ?>

6. AUTHENTICATION:
   - Add session_start() at the top of each PHP file
   - Check if user is logged in: if(!isset($_SESSION['user'])) { header('Location: login.php'); }
*/
