package com.example.deisacompose.ui.components

import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Clear
import androidx.compose.material.icons.filled.Search
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.unit.dp
import kotlinx.coroutines.Job
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

/**
 * Realtime search composable with debounce
 * @param onSearchChange Callback that will be called after debounce delay (default 300ms)
 */
@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun RealtimeSearchBar(
    placeholder: String,
    onSearchChange: (String) -> Unit,
    modifier: Modifier = Modifier,
    initialValue: String = "",
    debounceMs: Long = 300,
    focusedBorderColor: androidx.compose.ui.graphics.Color = MaterialTheme.colorScheme.primary
) {
    var searchQuery by remember { mutableStateOf(initialValue) }
    val scope = rememberCoroutineScope()
    var searchJob by remember { mutableStateOf<Job?>(null) }

    OutlinedTextField(
        value = searchQuery,
        onValueChange = { newValue ->
            searchQuery = newValue
            // Cancel previous search job
            searchJob?.cancel()
            // Launch new search job with debounce
            searchJob = scope.launch {
                delay(debounceMs)
                onSearchChange(newValue)
            }
        },
        modifier = modifier.fillMaxWidth(),
        placeholder = { Text(placeholder) },
        leadingIcon = {
            Icon(
                Icons.Default.Search,
                contentDescription = "Search",
                tint = MaterialTheme.colorScheme.onSurfaceVariant
            )
        },
        trailingIcon = {
            if (searchQuery.isNotEmpty()) {
                IconButton(onClick = {
                    searchQuery = ""
                    onSearchChange("")
                }) {
                    Icon(
                        Icons.Default.Clear,
                        contentDescription = "Clear",
                        tint = MaterialTheme.colorScheme.onSurfaceVariant
                    )
                }
            }
        },
        shape = RoundedCornerShape(12.dp),
        colors = OutlinedTextFieldDefaults.colors(
            unfocusedBorderColor = androidx.compose.ui.graphics.Color.Transparent,
            focusedBorderColor = focusedBorderColor,
            unfocusedContainerColor = MaterialTheme.colorScheme.surface,
            focusedContainerColor = MaterialTheme.colorScheme.surface
        ),
        singleLine = true,
        keyboardOptions = KeyboardOptions(imeAction = ImeAction.Search),
        textStyle = MaterialTheme.typography.bodyMedium
    )
}
