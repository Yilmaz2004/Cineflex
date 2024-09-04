<?php
// Define the number of rows and columns for each room
$num_rows = 6;
$num_cols = 12;

// Define the number of rooms
$num_rooms = 2;

// Function to check if a seat is selected
function isSeatSelected($room, $row, $col) {
    return isset($_SESSION['selected_seats'][$room][$row][$col]) && $_SESSION['selected_seats'][$room][$row][$col] == true;
}

// Function to toggle seat selection
function toggleSeat($room, $row, $col) {
    if (isset($_SESSION['selected_seats'][$room][$row][$col])) {
        $_SESSION['selected_seats'][$room][$row][$col] = !$_SESSION['selected_seats'][$room][$row][$col];
    } else {
        $_SESSION['selected_seats'][$room][$row][$col] = true;
    }
}

// Initialize selected seats array if not already set
if (!isset($_SESSION['selected_seats'])) {
    for ($room = 1; $room <= $num_rooms; $room++) {
        $_SESSION['selected_seats'][$room] = array_fill(1, $num_rows, array_fill(1, $num_cols, false));
    }
}

// Handle seat selection
if (isset($_POST['room']) && isset($_POST['row']) && isset($_POST['col'])) {
    $room = $_POST['room'];
    $row = $_POST['row'];
    $col = $_POST['col'];
    toggleSeat($room, $row, $col);
}
?>
<body>
<h2>Select Your Seat</h2>
<form method="post">
    <div class="room-container">
        <div class="tv">TV</div> <!-- TV object for room 1 -->
        <div class="room">
            <?php $letters = range('A', 'Z'); ?>
            <?php for ($row = 0; $row < $num_rows; $row++): ?>
                <?php for ($col = 1; $col <= $num_cols; $col++): ?>
                    <?php $seat_label = $letters[$row] . $col; ?>
                    <?php if (isSeatSelected(1, $row + 1, $col)): ?>
                        <div class="seat selected" data-room="1" data-row="<?php echo $row + 1; ?>" data-col="<?php echo $col; ?>">
                            <span class="seat-label"><?php echo $seat_label; ?></span> <!-- Show seat label -->
                        </div>
                    <?php else: ?>
                        <div class="seat" data-room="1" data-row="<?php echo $row + 1; ?>" data-col="<?php echo $col; ?>">
                            <span class="seat-label"><?php echo $seat_label; ?></span> <!-- Show seat label -->
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
        <div class="room">
            <?php for ($row = 0; $row < $num_rows; $row++): ?>
                <?php for ($col = 1; $col <= $num_cols; $col++): ?>
                    <?php $seat_label = $letters[$row] . ($col + $num_cols); ?>
                    <?php if (isSeatSelected(2, $row + 1, $col)): ?>
                        <div class="seat selected" data-room="2" data-row="<?php echo $row + 1; ?>" data-col="<?php echo $col; ?>">
                            <span class="seat-label"><?php echo $seat_label; ?></span> <!-- Show seat label -->
                        </div>
                    <?php else: ?>
                        <div class="seat" data-room="2" data-row="<?php echo $row + 1; ?>" data-col="<?php echo $col; ?>">
                            <span class="seat-label"><?php echo $seat_label; ?></span> <!-- Show seat label -->
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
    </div>
</form>

<script>
    // JavaScript to handle seat selection
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', () => {
            // Send seat coordinates to PHP script using AJAX
            let room = seat.getAttribute('data-room');
            let row = seat.getAttribute('data-row');
            let col = seat.getAttribute('data-col');
            let formData = new FormData();
            formData.append('room', room);
            formData.append('row', row);
            formData.append('col', col);
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Update seat selection status based on response
                    if (seat.classList.contains('selected')) {
                        seat.classList.remove('selected');
                    } else {
                        seat.classList.add('selected');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
</body>



