package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Jurusan

class JurusanAdapter(
    private var list: List<Jurusan>,
    private val onEdit: (Jurusan) -> Unit,
    private val onDelete: (Jurusan) -> Unit
) : RecyclerView.Adapter<JurusanAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvNamaJurusan: TextView = view.findViewById(R.id.tvNamaJurusan)
        val tvId: TextView = view.findViewById(R.id.tvId)
        val btnEdit: ImageView = view.findViewById(R.id.btnEdit)
        val btnDelete: ImageView = view.findViewById(R.id.btnDelete)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_jurusan, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = list[position]
        holder.tvNamaJurusan.text = item.namaJurusan
        holder.tvId.text = "ID: #${item.id}"

        holder.btnEdit.setOnClickListener { onEdit(item) }
        holder.btnDelete.setOnClickListener { onDelete(item) }
    }

    override fun getItemCount() = list.size

    fun updateList(newList: List<Jurusan>) {
        list = newList
        notifyDataSetChanged()
    }
}
