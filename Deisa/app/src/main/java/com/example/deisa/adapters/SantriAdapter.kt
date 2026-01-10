package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Santri

class SantriAdapter(private val onClick: (Santri) -> Unit) : RecyclerView.Adapter<SantriAdapter.ViewHolder>() {

    private val list = mutableListOf<Santri>()

    fun setData(newList: List<Santri>) {
        list.clear()
        list.addAll(newList)
        notifyDataSetChanged()
    }

    inner class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val ivAvatar: ImageView = itemView.findViewById(R.id.ivAvatar)
        val tvName: TextView = itemView.findViewById(R.id.tvName)
        val tvNisKelas: TextView = itemView.findViewById(R.id.tvNisKelas)
        val tvStatus: TextView = itemView.findViewById(R.id.tvStatus)

        fun bind(santri: Santri) {
            tvName.text = santri.displayName()
            tvNisKelas.text = "NIS: ${santri.nis ?: "-"} • ${santri.displayKelas()}"
            
            val status = santri.statusKesehatan ?: "sehat"
            tvStatus.text = status.replaceFirstChar { it.uppercase() }
            
            if (status.lowercase() == "sakit") {
                tvStatus.setBackgroundResource(R.drawable.bg_status_sakit)
                tvStatus.setTextColor(itemView.context.getColor(android.R.color.holo_red_dark))
            } else {
                tvStatus.setBackgroundResource(R.drawable.bg_status_sehat)
                tvStatus.setTextColor(itemView.context.getColor(android.R.color.holo_green_dark))
            }
            
            itemView.setOnClickListener { onClick(santri) }
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_santri, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.bind(list[position])
    }

    override fun getItemCount(): Int = list.size
}
