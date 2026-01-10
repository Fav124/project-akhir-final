package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Kelas

class KelasAdapter(
    private var list: List<Kelas>,
    private val onEdit: (Kelas) -> Unit,
    private val onDelete: (Kelas) -> Unit
) : RecyclerView.Adapter<KelasAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvNamaKelas: TextView = view.findViewById(R.id.tvNamaKelas)
        val tvId: TextView = view.findViewById(R.id.tvId)
        val btnEdit: ImageView = view.findViewById(R.id.btnEdit)
        val btnDelete: ImageView = view.findViewById(R.id.btnDelete)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_kelas, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = list[position]
        holder.tvNamaKelas.text = item.namaKelas
        holder.tvId.text = "ID: #${item.id}"

        holder.btnEdit.setOnClickListener { onEdit(item) }
        holder.btnDelete.setOnClickListener { onDelete(item) }
    }

    override fun getItemCount() = list.size

    fun updateList(newList: List<Kelas>) {
        list = newList
        notifyDataSetChanged()
    }
}
